<?php

namespace Modules\Storage\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Storage\app\actions\CreateFolderAction;
use Modules\Storage\app\DataTransferObjects\CreateFileDto;
use Modules\Storage\Models\File;
use Tests\TestCase;

class CreateFolderActionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_it_create_folder_inside_root(): void
    {
        $data = ['name' => 'folder1', 'is_folder' => true];
        $parent = null;
        $action = resolve(CreateFolderAction::class);
        $file = $action->execute(new CreateFileDto($data['name'], $data['is_folder'], null));
        $this->assertInstanceOf(File::class, $file);
        $this->assertEquals('folder1', $file->name);
    }

    public function test_it_create_file_inside_created_folder(): void
    {
        $folder = File::create(['name' => 'parent', 'is_folder' => true]);
        $data = ['name' => 'file1.txt', 'is_folder' => false];
        $parent = $folder;
        $action = resolve(CreateFolderAction::class);
        $file = $action->execute(new CreateFileDto($data['name'], $data['is_folder'], $parent));
        $this->assertInstanceOf(File::class, $file);
        $this->assertEquals('file1.txt', $file->name);
        $this->assertEquals($parent->id, $file->parent_id);
    }
}
