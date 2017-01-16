<?php

namespace App\Controllers;

use App\Models;

Class PageController Extends BaseController
{
    protected function getTemplateNames()
    {
        $this->templateInfo['templateNames'] = ['head', 'navbar', 'leftcolumn', 'rightcolumn', 'footer'];
    }
    protected function getTitle()
    {
        $this->templateInfo['title'] = 'ThinkSocial';
    }
    protected function getControllerVars()
    {

        $joins = ['UsersAvatars'=>'left/users.id/user_id/status=\'active\''];
        $user = Models\Users::fetchByParams(
            ['id'=>Models\Users::checkLogged(), 'status'=>'active'],
            'ACTIVE',
            $joins
        );
//        var_dump($user);
        if (isset($user->{'users_avatars.id'})) {
            $commentAvatarNum = Models\UsersAvatarsComments::count(['user_avatar_id' => $user->{'users_avatars.id'}]);
        } else {
            $commentAvatarNum = 0;
        }
        $joins = ['Cities'=>'left/cities.id/city_id',
            'Countries'=>'left/countries.id/country_id'
        ];
        $user_cities = Models\UsersCities::fetchByParams(
            ['user_id'=>$user->id],
            'ACTIVE',
            $joins,
            ' ORDER BY users_cities.created_at'
        );
//        var_dump($user_cities);

        $joins = ['Groups'=>'left/groups.id/group_id'];
        $user_groups = Models\UsersGroups::fetchByParams(
            ['user_id'=>$user->id],
            'ACTIVE',
            $joins
        );
//        var_dump($user_groups); die;
        $joins = ['Albums'=>'left/albums.id/album_id',
            'AlbumsPhotos'=>'left/albums.id/albums_photos.album_id/status=\'active\''];
        $userAlbums = Models\AlbumsUsers::fetchByParams(
            ['user_id' => $user->id],
            'ACTIVE',
            $joins
        );
        var_dump($userAlbums);
        $commentPhotosNum = 0;
        foreach ($userAlbums as $user_album) {
                $commentPhotosNum += Models\AlbumsPhotosComments::count(
                    ['albums_photos_id' => $user_album->{'albums_photos.id'}]
                );
        }

        $joins = ['News'=>'left/news_id/news.id'];

//        Models\UsersNews::join('newsId', 'App\Models\News', 'id');
//        Models\UsersNews::join('newsId', 'App\Models\NewsComment', 'newsId', ' LIMIT 3');
//        Models\NewsComments::join('commentId', 'App\Models\Comment', 'id', " AND status='active'");
//        Models\Comments::join('userId', 'App\Models\User', 'id');
        $user_news = Models\UsersNews::fetchByParams(
            ['user_id' => $user->id],
            'ACTIVE',
            $joins
        );
        var_dump($user_news);
        $joins = [
            'NewsComments'=>'left/users_news.news_id/news_comments.news_id',
            'Comments'=>'left/news_comments.comment_id/comments.id/status=\'active\''
        ];

//        Models\UsersNews::join('newsId', 'App\Models\News', 'id');
//        Models\UsersNews::join('newsId', 'App\Models\NewsComment', 'newsId', ' LIMIT 3');
//        Models\NewsComments::join('commentId', 'App\Models\Comment', 'id', " AND status='active'");
//        Models\Comments::join('userId', 'App\Models\User', 'id');
        $user_news_comments = Models\UsersNews::fetchByParams(
            ['user_id' => $user->id],
            'ACTIVE',
            $joins
        );
        var_dump($user_news_comments);

        $commentNewsNum = count($user_news_comments);
//        foreach ($user_news_comments as $user_news_comment) {
//            $commentNewsNum += Models\NewsComments::count(['news_id' => $user_news_comment->news_id]);
//        }
        var_dump($commentNewsNum); die;
        Models\Friends::join('userSender', 'App\Models\User', 'id');
        $friendReqs = Models\Friends::getByCondition(['userReceiver' => $user->id, 'status' => 'unapplied'], " ORDER BY created_at DESC");

        $unreadMessagesNum = Models\Messages::count(['receiverId' => $user->id, 'status' => 'unread']);

        $result = compact("unreadMessagesNum", "commentPhotosNum", "commentNewsNum", "commentAvatarNum",
                   "user", "userCities", "userGroups", "userAlbums", "userNews", "friendReqs");
        $result["userAvatar"] = $user->userAvatar;
        return $result;
    }
}
