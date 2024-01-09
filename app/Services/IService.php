<?php
/**
 * Using this interface we can create a service class
 * 
 * @package    Service Interface
 * @author     Md Shariful Hasan
 * 
 */
namespace App\Services;
use Illuminate\Http\Request;

interface IService {
    
    /**
     * Get all data
     * @return mixed
     */
    public function getAll();
    /**
     * Create a new data
     * @param Request $data 
     * @return mixed
     */
    public function create(Request $data);
    /**
     * Update a data
     * @param Request $data
     * @param $id
     * @return mixed
     */
    public function update(Request $data,$id);
    /**
     * Delete a data
     * @param $id
     * @return mixed
     */
    public function delete($id);
    /**
     * Get a data by id
     * @param $id
     * @return mixed
     */
    public function getByID($id);
   
}


?>