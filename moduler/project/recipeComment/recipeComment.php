<?php
moduler::simport('iComments');
class recipeComment extends iComments{
	public $table='recipeComments';
	public $parentId;
	public $pIdField='recipeId';
}
?>
