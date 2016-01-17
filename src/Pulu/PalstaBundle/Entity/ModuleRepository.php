<?php
namespace Pulu\PalstaBundle\Entity;

use Pulu\PalstaBundle\Entity\Module;
use Doctrine\ORM\EntityRepository;

class ModuleRepository extends EntityRepository {

    public function moduleSQLExists($type) {
        if ($type == Module::TYPE_ADMIN_BEER_TASTING) {
            return $this->getEntityManager()->getConnection()->getSchemaManager()->tablesExist(array(
                'module_beer',
                'module_beer_style',
                'module_beer_country'
            ));
        } else if ($type == Module::TYPE_ADMIN_MUNICIPALITY) {
            return $this->getEntityManager()->getConnection()->getSchemaManager()->tablesExist(array(
                'module_municipality',
                'module_municipality_sign_image'
            ));
        }
        return false;
    }

    public function getModuleSQL($type) {

        switch ($type) {
            case Module::TYPE_ADMIN_BEER_TASTING:
                return trim(
"CREATE TABLE module_beer (
  id SERIAL,
  drunk_date TIMESTAMP(0) DEFAULT NOW(),
  name VARCHAR NOT NULL,
  country INTEGER DEFAULT NULL,
  style INTEGER DEFAULT NULL,
  alc NUMERIC(5,2) DEFAULT '0.00',
  price NUMERIC(5,2) DEFAULT '0.00',
  grade INTEGER DEFAULT NULL,
  description TEXT,
  added TIMESTAMP(0) DEFAULT NOW(),
  deleted TIMESTAMP(0) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE module_beer_country (
  id SERIAL,
  name VARCHAR DEFAULT NULL,
  deleted DATE DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE module_beer_style (
  id SERIAL,
  name VARCHAR DEFAULT NULL,
  deleted DATE DEFAULT NULL,
  PRIMARY KEY (id)
);"
                );
                break;
            case Module::TYPE_ADMIN_MUNICIPALITY:
                return trim(
"CREATE TABLE module_municipality (
  id SERIAL,
  name VARCHAR NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE module_sign_image (
  id SERIAL,
  municipality_id INTEGER NOT NULL,
  filename VARCHAR NOT NULL,
  taken TIMESTAMP(0) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (municipality_id) REFERENCES module_municipality (id) ON DELETE SET NULL
);

CREATE TABLE module_building (
  id SERIAL,
  research_id INTEGER,
  municipality_id INTEGER NOT NULL,
  built TIMESTAMP(0) NULL,
  built_precision INTEGER NULL,
  demolished TIMESTAMP(0) NULL,
  demolished_precision INTEGER NULL,
  deployed TIMESTAMP(0) NULL,
  deployed_precision INTEGER NULL,
  obsoleted TIMESTAMP(0) NULL,
  obsoleted_precision INTEGER NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (municipality_id) REFERENCES module_municipality (id) ON DELETE SET NULL
);

CREATE TABLE module_municipality_building (
  municipality_id INTEGER NOT NULL,
  building_id INTEGER NOT NULL,
  deployed TIMESTAMP(0) NULL,
  deployed_precision INTEGER NULL,
  obsoleted TIMESTAMP(0) NULL,
  obsoleted_precision INTEGER NULL,
  PRIMARY KEY (municipality_id, building_id),
  FOREIGN KEY (municipality_id) REFERENCES module_municipality (id) ON DELETE CASCADE,
  FOREIGN KEY (building_id) REFERENCES module_building (id) ON DELETE CASCADE
);

CREATE TABLE module_building_image (
  id SERIAL,
  building_id INTEGER NOT NULL,
  filename VARCHAR NOT NULL,
  taken TIMESTAMP(0) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (building_id) REFERENCES module_building (id) ON DELETE SET NULL
);"
            );
            default:
                break;
        }

    }

    public function getBeers() {
        $sql = "SELECT A.*, B.name AS style_name, C.name AS country_name, ROW_NUMBER() OVER (ORDER BY A.drunk_date ASC, A.id ASC) FROM module_beer A JOIN module_beer_style B ON (A.style = B.id) JOIN module_beer_country C ON (A.country = C.id) WHERE A.deleted IS NULL ORDER BY A.drunk_date DESC, A.id DESC";
        $stm = $this->getEntityManager()->getConnection()->query($sql);
        return $stm->fetchAll();
    }

    public function getBeer($id) {
        $sql = "SELECT A.*, B.name AS style_name, C.name AS country_name FROM module_beer A JOIN module_beer_style B ON (A.style = B.id) JOIN module_beer_country C ON (A.country = C.id) WHERE A.id = ?";
        $stm = $this->getEntityManager()->getConnection()->prepare($sql);
        $stm->execute(array($id));
        return $stm->fetch();
    }

    public function getBeerStyles() {
        $sql = "SELECT * FROM module_beer_style WHERE deleted IS NULL ORDER BY name ASC";
        $stm = $this->getEntityManager()->getConnection()->query($sql);
        return $stm->fetchAll();
    }

    public function getBeerCountries() {
        $sql = "SELECT * FROM module_beer_country WHERE deleted IS NULL ORDER BY name ASC";
        $stm = $this->getEntityManager()->getConnection()->query($sql);
        return $stm->fetchAll();
    }

    public function saveBeer($id = null, $data = array()) {
        if (! is_numeric($data['style'])) {
            $sql = "INSERT INTO module_beer_style (id, name) VALUES (DEFAULT, ?) RETURNING id";
            $stm = $this->getEntityManager()->getConnection()->prepare($sql);
            $stm->execute(array($data['style']));
            $new_style_id = $stm->fetchColumn();
            $stm->closeCursor();
            $data['style'] = $new_style_id;
        }
        if (! is_numeric($data['country'])) {
            $sql = "INSERT INTO module_beer_country (id, name) VALUES (DEFAULT, ?) RETURNING id";
            $stm = $this->getEntityManager()->getConnection()->prepare($sql);
            $stm->execute(array($data['country']));
            $new_country_id = $stm->fetchColumn();
            $stm->closeCursor();
            $data['country'] = $new_country_id;
        }
        if (empty($id)) {
            $sql = "INSERT INTO module_beer (id, name, price, alc, grade, drunk_date, style, country, description) VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?, ?) RETURNING id";
            $stm = $this->getEntityManager()->getConnection()->prepare($sql);
            $stm->execute(array($data['name'], $data['price'], $data['alc'], $data['grade'], $data['drunk'], $data['style'], $data['country'], $data['desc']));
            $new_beer_id = $stm->fetchColumn();
            $stm->closeCursor();
            return $new_beer_id;
        } else {
            $sql = "UPDATE module_beer SET name = ?, price = ?, alc = ?, grade = ?, drunk_date = ?, style = ?, country = ?, description = ? WHERE id = ?";
            $stm = $this->getEntityManager()->getConnection()->prepare($sql);
            $stm->execute(array($data['name'], $data['price'], $data['alc'], $data['grade'], $data['drunk'], $data['style'], $data['country'], $data['desc'], $id));
            $stm->closeCursor();
            return $id;
        }
    }

    public function deleteBeer($beer_id) {
        $sql = "UPDATE module_beer SET deleted = NOW() WHERE id = ?";
        $stm = $this->getEntityManager()->getConnection()->prepare($sql);
        $stm->execute(array($beer_id));
        return $stm->closeCursor();
    }

    public function getBeerCount($filters = array()) {
        $sql = "SELECT COUNT(*) FROM module_beer";
        if (! empty($filters['where'])) {
            $sql .= ' WHERE ' . $filters['where'];
        }
        $stm = $this->getEntityManager()->getConnection()->query($sql);
        return $stm->fetchColumn();
    }

    public function getByQuery($sql, $fetchMethod = 'fetchColumn') {
        $stm = $this->getEntityManager()->getConnection()->query($sql);
        return $stm->$fetchMethod();
    }

    public function getMunicipalitiesWithSignImages() {
        $sql = "SELECT A.*, B.* FROM module_municipality A JOIN module_sign_image B ON (B.municipality_id = A.id) ORDER BY A.Name COLLATE \"fi_FI\" ASC";
        $stm = $this->getEntityManager()->getConnection()->query($sql);
        return $stm->fetchAll();
    }

    public function getNewMunicipalitySignImagesPerDay() {
        $sql = "SELECT COUNT(*) AS count, DATE_TRUNC('DAY', taken) AS day FROM module_sign_image GROUP BY day ORDER BY day";
        $stm = $this->getEntityManager()->getConnection()->query($sql);
        return $stm->fetchAll();
    }

    public function getBuildingImages() {
        $sql = "
        SELECT
            A.name, C.built, C.built_precision, B.deployed, B.deployed_precision, D.filename, D.taken, B.building_id
        FROM
            module_municipality A
        JOIN
            module_municipality_building B ON (B.municipality_id = A.id)
        JOIN
            module_building C ON (C.id = B.building_id)
        JOIN
            module_building_image D ON (D.building_id = C.id)
        ORDER BY
            A.name COLLATE \"fi_FI\" ASC
        ";
        $stm = $this->getEntityManager()->getConnection()->query($sql);
        return $stm->fetchAll();
    }

    public function getNewMunicipalityBuildingImagesPerDay() {
        $sql = "SELECT COUNT(*) AS count, DATE_TRUNC('DAY', taken) AS day FROM module_building_image GROUP BY day ORDER BY day";
        $stm = $this->getEntityManager()->getConnection()->query($sql);
        return $stm->fetchAll();
    }

}
