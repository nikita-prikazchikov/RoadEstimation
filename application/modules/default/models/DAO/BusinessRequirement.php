<?php
class Model_DAO_BusinessRequirement{

    public function saveBusinessRequirement(
                Model_DBObject_BusinessRequirement $br,
                Model_DBObject_BusinessRequirementVersion $version
    ){
        if(null === ($id = $br->getId())){
            //add new records BusinessRequirement, BusinessRequirementVersion
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try{
                $mapperBusinessRequirement = Model_DBMapper_BusinessRequirementMapper::get_instance();
                $mapperBusinessRequirementVersion = Model_DBMapper_BusinessRequirementVersionMapper::get_instance();

                // insert business requirement
                $mapperBusinessRequirement->save($br);

                // insert version
                $version->setIdBusinessRequirement($br->getId());
                $mapperBusinessRequirementVersion->save($version);

                // update version id
                $br->setIdVersion($version->getId());
                $mapperBusinessRequirement->save($br);

                $db->commit();
            }
            catch(Exception $ex){
                $db->rollBack();
                throw $ex;
            }
        }
        else{
            // TODO make  update requirement logic
        }
    }
}
 
