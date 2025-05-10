<?php
namespace Modules\Storage\app\actions;

use Modules\Storage\app\DataTransferObjects\CreateFileDto;
use Modules\Storage\Models\File;

class CreateFolderAction 
{
    /** @param File|null $parent */
    public function execute(CreateFileDto $dto)
    {
        if(!$dto->parent) 
            $dto->parent= File::orderBy('id')->first();

        return $dto->parent->children()->create(['name' => $dto->name, 'is_folder' => $dto->isFolder]);
    }
}