<?php

$factory->define(App\Model\Models\Survey::class, function (Faker\Generator $faker, $data) 
{

    return [
        'title' => $faker->sentence(),
        'description' => $faker->sentence(),
		'icon' => $data['icon'],
		'user_id' => $data['user_id']
    ];

});

$factory->define(App\Model\Models\Question::class, function (Faker\Generator $faker, $data) 
{

    return [
        'question' => $faker->sentence(),
        'option1' => $data['option1'],
		'option2' => $data['option2'],
		'option3' => $data['option3'],
		'option4' => $data['option4'],
		'survey_id' => $data['survey_id'],
    ];

});

$factory->define(App\Model\Models\User::class, function (Faker\Generator $faker, $data) 
{

    return [
        'email' => isset($data['email']) ? $data['email'] : $faker->email,
        'name' => $faker->name(),
		'access_level' => $data['access_level'],
		'auth_key' => '109511313140306130594'
    ];

});
