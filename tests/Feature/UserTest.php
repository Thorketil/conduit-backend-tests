<?php

namespace Tests\Feature;

use App\Models\Article;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserTest extends TestCase
{
//    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_getRouteKeyName()
    {
        $user = new User();
//        var_dump($user);
        $this->assertEquals('username', $user->getRouteKeyName());
    }

    public function test_articles()
    {
        $user = User::all()->firstWhere("username", "Rose");
//       echo $user -> articles();
//        echo "\n";
//        echo $user->articles;
        $this->assertInstanceOf(Article::class, $user->articles->first());
        $this->assertInstanceOf(Article::class, $user->articles()->first());
        $this->assertInstanceOf(Collection::class, $user->articles);
        $this->assertInstanceOf(HasMany::class, $user->articles());
    }

    public function test_favouritedArticles()
    {
        $user = User::all()->firstWhere("username", "Rose");
//        echo "\n";
//        echo $user->favouritedArticles;
        $this->assertInstanceOf(Article::class, $user->favoritedArticles->first());

    }

    public function test_followers()
    {
        $user = User::all()->firstWhere("username", "Rose");
//        echo "\n";
//        echo $user->followers;
        $this->assertInstanceOf(User::class, $user->followers->first());
    }

    public function test_following()
    {
        $user = User::all()->firstWhere("username", "Rose");
//        echo "\n";
//        echo $user->following;
        $this->assertInstanceOf(User::class, $user->following->first());
    }

    public function test_doesUserFollowAnotherUser()
    {
        $user = User::all()->firstWhere("username", "Rose");
        $user2 = User::all()->firstWhere("username", "Musonda");
        $this->assertTrue($user->doesUserFollowAnotherUser($user->id, $user2->id));
    }

    public function test_doesUserFollowArticle()
    {
        $user = User::all()->firstWhere("username", "Musonda");
        $article = Article::all()->firstWhere("title", "Coucou je suis Rose j'aime pas mes gosses");
        $this->assertTrue($user->doesUserFollowArticle($user->id, $article->id));
    }

    public function test_setPasswordAttribute()
    {
        $user = User::all()->firstWhere("username", "Rose");
        echo "\n";
        echo $user->password;
        echo "\n";
        $mdp = $user->password;
        $user->setPasswordAttribute("truc");
        echo $user->password;
        echo "\n";
        echo $mdp;
        $this->assertNotEquals($mdp, $user->password);
    }

    public function test_getJWTIdentifier()
    {
        $user = User::all()->firstWhere("username", "Rose");
        $this->assertEquals($user->id, $user->getJWTIdentifier());
    }
}
