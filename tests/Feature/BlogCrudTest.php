<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Blog\Models\BlogPost;
use Tests\TestCase;

class BlogCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public list blogs.
     */
    public function test_anyone_can_list_blogs()
    {
        BlogPost::create([
            'id' => 'test-blog-1',
            'title' => 'Test Blog 1',
            'excerpt' => 'Test excerpt',
            'category' => 'Logistics',
            'author' => 'Author Name',
            'author_role' => 'Role',
            'date' => 'July 1, 2026',
            'read_time' => '5 min read',
            'image' => 'test.jpg',
            'featured' => false,
        ]);

        $response = $this->getJson('/api/blogs');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', 'test-blog-1');
    }

    /**
     * Test create blog post.
     */
    public function test_admin_can_create_blog()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/blogs', [
                'id' => 'new-blog-post',
                'title' => 'New Blog Post Title',
                'excerpt' => 'New blog excerpt text.',
                'category' => 'Shipping',
                'author' => 'Jonathan Vance',
                'author_role' => 'CEO',
                'date' => 'August 7, 2026',
                'read_time' => '3 min read',
                'image' => 'blog.jpg',
                'featured' => true,
                'content' => ['Paragraph 1', 'Paragraph 2'],
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.id', 'new-blog-post');

        $this->assertDatabaseHas('blogs', [
            'id' => 'new-blog-post',
            'title' => 'New Blog Post Title',
        ]);
    }

    /**
     * Test update blog post.
     */
    public function test_admin_can_update_blog()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $blog = BlogPost::create([
            'id' => 'old-blog',
            'title' => 'Old Title',
            'excerpt' => 'Old excerpt.',
            'category' => 'Logistics',
            'author' => 'Author',
            'author_role' => 'Role',
            'date' => 'July 10, 2026',
            'read_time' => '4 min read',
            'image' => 'old.jpg',
            'featured' => false,
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/blogs/{$blog->id}", [
                'title' => 'Updated Title',
                'excerpt' => 'Updated excerpt.',
                'category' => 'Aviation',
                'author' => 'New Author',
                'author_role' => 'Director',
                'date' => 'July 15, 2026',
                'read_time' => '6 min read',
                'image' => 'new.jpg',
                'featured' => true,
                'tags' => ['Aviation', 'Cargo'],
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Title')
            ->assertJsonPath('data.category', 'Aviation')
            ->assertJsonPath('data.tags.0', 'Aviation');
    }

    /**
     * Test delete blog post.
     */
    public function test_admin_can_delete_blog()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $blog = BlogPost::create([
            'id' => 'to-delete',
            'title' => 'To Delete',
            'excerpt' => 'To delete excerpt.',
            'category' => 'Logistics',
            'author' => 'Author',
            'author_role' => 'Role',
            'date' => 'July 20, 2026',
            'read_time' => '2 min read',
            'image' => 'delete.jpg',
            'featured' => false,
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/blogs/{$blog->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
    }
}
