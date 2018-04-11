<?php

namespace spec\Acme;

use Acme\File;
use Acme\Filesystem;
use PhpSpec\ObjectBehavior;

class TextEditorSpec extends ObjectBehavior
{
    const FILENAME = 'some.txt';
    const FORCE_FILE_CREATION = false;

    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_creates_new_files(File $file, Filesystem $filesystem)
    {
        $filesystem->exists(self::FILENAME)->willReturn(false);
        $filesystem->create(self::FILENAME)->willReturn($file);

        $this->open(self::FILENAME, self::FORCE_FILE_CREATION)->shouldBe($file);
    }

    function it_cant_create_new_file_if_exists(Filesystem $filesystem)
    {
        $filesystem->exists(self::FILENAME)->willReturn(true);

        $this->open(self::FILENAME, self::FORCE_FILE_CREATION)->shouldBe(null);
    }
}
