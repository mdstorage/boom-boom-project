<?php

class Group implements GroupInterface{
    use CodeNameTrait;

    private $parent;
    private $picture;
    private $subgroups;
    private $options;

} 