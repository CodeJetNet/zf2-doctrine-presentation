<?php
/**
 * Created by PhpStorm.
 * User: houghtelin
 * Date: 9/1/15
 * Time: 7:22 PM
 */

namespace Application\Controller;

use Application\Model\Entity\Recipe;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RecipeController extends AbstractRestfulController
{
    private $db;

    public function getList()
    {
        $recipes = $this->getDb()->fetchAll(new Recipe);
        $return_recipes = [];

        foreach($recipes as $recipe) {
            array_push($return_recipes,$recipe->getArrayCopy());
        }

        return new JsonModel($return_recipes);
    }

    public function get($id)
    {
        $recipe = new Recipe(['id' => $id]);
        $recipe = $this->getDb()->fetch($recipe);

        return new JsonModel($recipe->getArrayCopy());
    }

    public function create($data)
    {
        $recipe = new Recipe($data);
        $this->getDb()->save($recipe);

        return new JsonModel($recipe->getArrayCopy());
    }

    public function update($id, $data)
    {

    }

    public function delete($id)
    {
    }

    private function getDb()
    {
        if(!$this->db) {
            $this->db = $this->getServiceLocator()->get('Application\Model\Db');
        }

        return $this->db;
    }
}