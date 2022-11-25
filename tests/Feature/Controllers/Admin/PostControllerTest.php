<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexMethod()
    {
        Post::factory()->count(100)->create();

        $this
            ->actingAs(User::factory()->admin()->create())
            ->get(route('posts.index'))
            ->assertOk()
            ->assertViewIs('admin.post.index')
            ->assertViewHas('posts', Post::latest()->paginate(15));
        $this->assertEquals(request()->route()->middleware(), ['web', 'admin']);
    }



    //test create post view
    public function testCreateMethod()
    {
        Tag::factory()->count(22)->create();
        $this
            ->actingAs(User::factory()->admin()->create())
            ->get(route('posts.create'))
            ->assertOk()
            ->assertViewIs('admin.post.create')
            ->assertViewHas('tags', Tag::latest()->get());
    }

    //test edit post view
    public function testEditMethod()
    {
        $post = Post::factory()->create();
        Tag::factory()->count(22)->create();
        $this
            ->actingAs(User::factory()->admin()->create())
            ->get(route('posts.edit', $post->id))
            ->assertOk()
            ->assertViewIs('admin.post.edit')
            ->assertViewHasAll([
                'tags' => Tag::latest()->get(),
                'post' => $post
            ]);
    }

    //test Store the Post
    public function testStoreMethod(){
        $data= Post::factory()->make()->toArray();
        dd($data);
    }
}
