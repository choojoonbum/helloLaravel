<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testReturnsIndexViewForListOfPost()
    {
        $blog = Blog::factory()->create();
        $this->actingAs($blog->user)->get(route('blogs.posts.index', $blog))
            ->assertOk()
            ->assertViewIs('blogs.posts.index');
    }

    public function testReturnsCreateViewForListOfPost()
    {
        $blog = Blog::factory()->create();
        $this->actingAs($blog->user)->get(route('blogs.posts.create', $blog))
            ->assertViewIs('blogs.posts.create');
    }

    public function testCreatePostForBlog()
    {
        $blog = Blog::factory()->hasSubscribers()->create();
        $data = [
            'title' => $this->faker->text(50),
            'content' => $this->faker->text
        ];

        $this->actingAs($blog->user)
            ->post(route('blogs.posts.store', $blog), $data)->assertRedirect();

        $this->assertCount(1, $blog->posts);
        $this->assertDatabaseHas('posts', $data);
    }

    public function testReturnsShowViewForPost()
    {
        $post = Post::factory()->create();

        $this->actingAs($post->blog->user)
            ->get(route('posts.show', $post))->assertOk()->assertViewIs('blogs.posts.show');
    }

    public function testReturnsEditViewForPost()
    {
        $post = Post::factory()->create();

        $this->actingAs($post->blog->user)->get(route('posts.edit', $post))
            ->assertOk()->assertViewIs('blogs.posts.edit');
    }

    public function testUpdatePost()
    {
        $post = Post::factory()->create();
        $data = [
            'title' => $this->faker->text(50),
            'content' => $this->faker->text
        ];
        $this->actingAs($post->blog->user)
            ->put(route('posts.update', $post), $data)
            ->assertRedirect();

        $this->assertDatabaseHas('posts', $data);
    }

    public function testDeletePost()
    {
        $post = Post::factory()->create();
        $this->actingAs($post->blog->user)->delete(route('posts.destroy',$post))
            ->assertRedirect();

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
