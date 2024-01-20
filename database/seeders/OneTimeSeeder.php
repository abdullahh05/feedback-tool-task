<?php

namespace Database\Seeders;

use App\Models\FeedBack;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OneTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ["Bug report", "Feature request", "Improvement", "others"];
        $users = [
            [
                "name" => "TestUser1",
                "email" => "testUser1@gmail.com",
                "password" => Hash::make("password"),
            ],
            [
                "name" => "TestUser2",
                "email" => "testUser2@gmail.com",
                "password" => Hash::make("password"),
            ],
            [
                "name" => "TestUser3",
                "email" => "testUser3@gmail.com",
                "password" => Hash::make("password"),
            ],
            [
                "name" => "TestUser4",
                "email" => "testUser4@gmail.com",
                "password" => Hash::make("password"),
            ],
        ];
        $feedBacks = [
          [
              "title" => "Application Crashes on Startup",
              "description" => "<p>Whenever I try to open the application, it crashes immediately.</p>",
              "category_id" => 1,
              "submit_by" => 2
          ],
          [
              "title" => "Incorrect Calculation in Billing Module",
              "description" => "<p>The <strong>billing module</strong> is not calculating totals <i>correctly</i> for certain transactions.</p>",
              "category_id" => 1,
              "submit_by" => 1
          ],
          [
              "title" => "Add Dark Mode Feature",
              "description" => "<p>It would be great to have a <strong>dark mode</strong> option for better <strong>visibility</strong> in low-light conditions.</p>",
              "category_id" => 2,
              "submit_by" => 2
          ],
          [
              "title" => "Integration with Third-Party APIs",
              "description" => "<p>Please <strong>consider</strong> adding integration support for <i>popular</i> third-party APIs.</p>",
              "category_id" => 2,
              "submit_by" => 2
          ],
          [
              "title" => "Enhance User Authentication Security",
              "description" => "<p>Improve the security measures for user </strong>authentication</strong>, such as implementing <i>two-factor</i> authentication</p>",
              "category_id" => 3,
              "submit_by" => 3
          ],
          [
              "title" => "Optimize Database Queries for Better Performance",
              "description" => "<p>Database queries need <strong>optimization</strong> to enhance overall system performance.</p>",
              "category_id" => 3,
              "submit_by" => 4
          ],
          [
              "title" => "General Feedback on User Interface",
              "description" => "<p>Provide <strong>feedback</strong> on the overall user interface <strong>design and usability</strong>.</p>",
              "category_id" => 4,
              "submit_by" => 4
          ],
          [
              "title" => "Suggestion for New Feature",
              "description" => "<p>I have a <i>suggestion </i>for a <strong>new feature</strong> that doesn\'t fit into the <strong>existing categories</strong>.</p>",
              "category_id" => 4,
              "submit_by" => 3
          ],
          [
              "title" => "Feedback title",
              "description" => "descript",
              "category_id" => 2,
              "submit_by" => 3
          ],
          [
              "title" => "Feedback title",
              "description" => "descript",
              "category_id" => 2,
              "submit_by" => 1
          ],
        ];

        //  add data in database
        foreach ($categories as $category) {
            \App\Models\Category::create([
                "name" => $category
            ]);
        }
        foreach ($users as $user) {
            User::create($user);
        }
        foreach ($feedBacks as $feedBack) {
            FeedBack::create($feedBack);
        }

    }
}
