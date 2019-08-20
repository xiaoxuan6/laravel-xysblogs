<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Good::class, function (Faker $faker) {
    $addresses = [
        "北京市市辖区东城区",
        "河北省石家庄市长安区",
        "江苏省南京市浦口区",
        "江苏省苏州市相城区",
        "广东省深圳市福田区",
    ];

    return [
        'name'  => $faker->name, // sentence,word, text
        'price'  => $faker->randomNumber(4),
        'order_id'  => \App\Model\Order::inRandomOrder()->first()->id, // 随机去一条数据
        'status'  => $faker->randomElement(['0', '1']),
        'rating'  => $faker->numberBetween(0, 5),
        'address'  => $faker->randomElement($addresses),
        'phone'  => $faker->phoneNumber,
        'trade_time' => $faker->dateTimeBetween('-30 days'), // 30天前到现在任意时间点
        'no' => $faker->uuid,
    ];
});
