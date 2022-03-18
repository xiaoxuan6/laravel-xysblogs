<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Observers;

use Avatar;
use App\Model\AdminUser;
use Illuminate\Support\Facades\Storage;

class AdminUserObserve
{
    public function creating(AdminUser $adminUser)
    {
        $adminUser->name = $adminUser->username;
        if ($adminUser->password != $adminUser->getOriginal('password')) {
            $adminUser->password = bcrypt($adminUser->password);
        }

        if (! $adminUser->avatar) {
            $path = 'images/' . strtolower($adminUser->username) . '.png';
            Avatar::create($adminUser->username)->save(public_path($path));
            Storage::disk('cosv5')->put($path, file_get_contents(public_path($path)));
            $adminUser->avatar = $path;
        }
    }
}
