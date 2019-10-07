<?php

namespace MikeTiEm\Valkyrie\Tests\Unit;

use Illuminate\Support\Facades\Config;
use MikeTiEm\Valkyrie\Tests\TestCase;

class HelperTest extends TestCase
{
    /** @test */
    function given_string_begins_with_foreign_key_prefix_tag()
    {
        $this->setPrefix();
        $this->assertTrue( startsWith('id_author') );
    }

    /** @test */
    function given_string_not_begins_with_foreign_key_prefix_tag()
    {
        $this->setPrefix();
        $this->assertFalse( endsWith('title') );
    }

    /** @test */
    function given_string_ends_with_foreign_key_suffix_tag()
    {
        $this->setSuffix();
        $this->assertTrue( endsWith('author_id') );
    }

    /** @test */
    function given_string_not_ends_with_foreign_key_suffix_tag()
    {
        $this->setSuffix();
        $this->assertFalse( endsWith('title') );
    }

    /** @test */
    function given_string_was_identified_as_foreign_key()
    {
        $this->assertTrue( isForeignKey('author_id') );
    }

    /** @test */
    function given_string_was_not_identified_as_foreign_key()
    {
        $this->assertFalse( isForeignKey('title') );
    }

    private function setPrefix()
    {
        Config::set('valkyrie.tag', 'id_');
    }

    private function setSuffix()
    {
        Config::set('valkyrie.tag', '_id');
    }
}