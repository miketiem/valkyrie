<?php

namespace MikeTiEm\Valkyrie\Tests\Unit;

use MikeTiEm\Valkyrie\Tests\Models\Article;
use MikeTiEm\Valkyrie\Tests\TestCase;

class FormatModelTest extends TestCase
{
    /** @test */
    function model_can_be_initialized()
    {
        $article = new Article;

        $article->fillable(['title', 'content', 'url']);

        $this->assertEquals([
            'title' => '',
            'content' => '',
            'url' => ''
        ], $article->initialize());
    }

    /** @test */
    function model_can_be_initialized_with_default_values()
    {
        $article = new Article;

        $article->fillable(['title', 'content', 'url', 'likes', 'date']);

        $article->values([
            'likes' => 0,
            'date' => date('m/d/Y')
        ]);

        $this->assertEquals([
            'title' => '',
            'content' => '',
            'url' => '',
            'likes' => 0,
            'date' => date('m/d/Y')
        ], $article->initialize());
    }

    /** @test */
    function model_can_be_initialized_with_foreign_keys()
    {
        $article = new Article;

        $article->fillable(['title', 'content', 'url', 'author_id']);

        $this->assertEquals([
            'title' => '',
            'content' => '',
            'url' => '',
            'author_id' => 0
        ], $article->initialize());
    }

    /** @test */
    function model_can_be_initialized_with_foreign_keys_and_default_values()
    {
        $article = new Article;

        $article->fillable(['title', 'content', 'url', 'likes', 'date', 'author_id']);

        $article->values([
            'likes' => 0,
            'date' => date('m/d/Y')
        ]);

        $this->assertEquals([
            'title' => '',
            'content' => '',
            'url' => '',
            'likes' => 0,
            'date' => date('m/d/Y'),
            'author_id' => 0
        ], $article->initialize());
    }
}