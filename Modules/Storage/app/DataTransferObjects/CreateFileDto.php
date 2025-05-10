<?php
namespace Modules\Storage\app\DataTransferObjects;

use Modules\Storage\Models\File;

class CreateFileDto
{
    public string $name;
    public ?File $parent;
    public bool $isFolder;

    public function __construct(string $name, bool $isFolder, ?File $parent=null)
    {
        $this->name= $name;
        $this->isFolder= $isFolder;
        $this->parent= $parent;
    }
}