<?php

namespace Tests\Feature\Views;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SingleViewTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSingleViewRenderedWhenUserLoggedIn()
    {

        $post = Post::factory()->create();
        $comments = [];
        $user = User::factory()->create();

        $view = (string) $this->actingAs($user)->view('single', compact('post', 'comments'));

        $dom = new DOMDocument();
        $dom->loadHTML($view);

        $xpath = new DOMXPath($dom);
        $action =  route('single.comment', $post->id);

        $this->assertCount(
            1,
            $xpath->query("//form[@method='post'][@action='$action']/textarea[@name='text']")
        );
    }

    public function testSingleViewRenderedWhenUserNotLoggedIn()
    {

        $post = Post::factory()->create();
        $comments = [];

        $view = (string) $this->view('single', compact('post', 'comments'));

        $dom = new DOMDocument();
        $dom->loadHTML($view);

        $xpath = new DOMXPath($dom);
        $action =  route('single.comment', $post->id);

        $this->assertCount(
            0,
            $xpath->query("//form[@method='post'][@action='$action']/textarea[@name='text']")
        );
    }
}
