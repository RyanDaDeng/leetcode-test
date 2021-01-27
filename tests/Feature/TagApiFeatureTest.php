<?php


namespace Tests\Feature;


use App\Models\Content;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagApiFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTest()
    {
        $tag = Tag::factory()->create();

        $response = $this->get('api/tags');

        $this->assertEquals(
            [
                'success' => true,
                'data' => [
                    [
                        'id' => $tag->getKey(),
                        'name' => $tag->name
                    ]
                ]
            ],
            $response->json()
        );
    }


    public function testSearchContentWithTags()
    {
        /**
         * @var Tag $tag
         */
        $tag = Tag::factory()->create();

        $content = Content::query()->create(
            [
                'name' => 'test'
            ]
        );

        $tag->contents()->attach($content->getKey());
        $response = $this->get(
            route('contents.list',
                [
                    'tag_id' => $tag->getKey()
                ]
            )
        );
        $response->assertJsonFragment(
            [
                'success' => true,
                'data' => [
                    [
                        'id' => $content->getKey(),
                        'name' => $content->name
                    ]
                ]
            ]
        );
    }


    public function testMostPopularTags()
    {
        /**
         * @var Tag $tag1
         */
        $tag1 = Tag::factory()->create();

        /**
         * @var Tag $tag2
         */
        $tag2 = Tag::factory()->create();

        /**
         * @var Tag $tag3
         */
        $tag3 = Tag::factory()->create();

        /**
         * @var Tag $tag4
         */
        $tag4 = Tag::factory()->create();

        $content = Content::query()->create(
            [
                'name' => 'test'
            ]
        );

        $content2 = Content::query()->create(
            [
                'name' => 'test2'
            ]
        );

        $content3 = Content::query()->create(
            [
                'name' => 'test3'
            ]
        );


        $tag1->contents()->attach($content->getKey());
        $tag2->contents()->attach([$content->getKey(), $content3->getKey(), $content2->getKey()]);
        $tag4->contents()->sync([$content->getKey(), $content2->getKey()]);


        $response = $this->get(route('contents.popularTag',));

        $response->assertJsonFragment(
            [
                'success' => true,
                'data' => [
                    [
                        'tag_count' => 3,
                        'tag_id' => $tag2->getKey()
                    ],
                    [
                        'tag_count' => 2,
                        'tag_id' => $tag4->getKey()
                    ],
                    [
                        'tag_count' => 1,
                        'tag_id' => $tag1->getKey()
                    ]
                ]
            ]
        );
    }


}
