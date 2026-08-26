<?php

namespace App\Support;

class Permissions
{
    /**
     * Permission tree: module => permissions. This is the single source of truth.
     */
    public static function all(): array
    {
        return [
            'dashboard' => ['dashboard.view'],
            'posts' => ['posts.view', 'posts.create', 'posts.update', 'posts.delete', 'posts.publish'],
            'articles' => ['articles.view', 'articles.create', 'articles.update', 'articles.delete', 'articles.publish'],
            'categories' => ['categories.manage'],
            'pages' => ['pages.view', 'pages.create', 'pages.update', 'pages.delete'],
            'announcements' => ['announcements.view', 'announcements.create', 'announcements.update', 'announcements.delete'],
            'events' => ['events.view', 'events.create', 'events.update', 'events.delete'],
            'achievements' => ['achievements.view', 'achievements.create', 'achievements.update', 'achievements.delete'],
            'programs' => ['programs.view', 'programs.create', 'programs.update', 'programs.delete'],
            'curriculums' => ['curriculums.view', 'curriculums.create', 'curriculums.update', 'curriculums.delete'],
            'calendars' => ['calendars.view', 'calendars.create', 'calendars.update', 'calendars.delete'],
            'extracurriculars' => ['extracurriculars.view', 'extracurriculars.create', 'extracurriculars.update', 'extracurriculars.delete'],
            'organizations' => ['organizations.view', 'organizations.create', 'organizations.update', 'organizations.delete'],
            'teachers' => ['teachers.view', 'teachers.create', 'teachers.update', 'teachers.delete'],
            'structure' => ['structure.manage'],
            'facilities' => ['facilities.view', 'facilities.create', 'facilities.update', 'facilities.delete'],
            'gallery' => ['gallery.view', 'gallery.create', 'gallery.update', 'gallery.delete'],
            'media' => ['media.manage'],
            'videos' => ['videos.view', 'videos.create', 'videos.update', 'videos.delete'],
            'alumni' => ['alumni.view', 'alumni.create', 'alumni.update', 'alumni.delete', 'alumni.verify'],
            'downloads' => ['downloads.view', 'downloads.create', 'downloads.update', 'downloads.delete'],
            'messages' => ['messages.view', 'messages.delete'],
            'users' => ['users.view', 'users.create', 'users.update', 'users.delete'],
            'roles' => ['roles.manage'],
            'menus' => ['menus.manage'],
            'settings' => ['settings.manage'],
            'redirects' => ['redirects.manage'],
            'logs' => ['logs.view'],
            'backup' => ['backup.manage'],
        ];
    }

    public static function flatten(): array
    {
        return array_merge(...array_values(self::all()));
    }

    public static function roleMap(): array
    {
        return [
            'Super Administrator' => ['*'],
            'Administrator' => self::flatten(),
            'Humas / Editor' => [
                'dashboard.view',
                'posts.view', 'posts.create', 'posts.update', 'posts.delete', 'posts.publish',
                'articles.view', 'articles.create', 'articles.update', 'articles.delete', 'articles.publish',
                'categories.manage',
                'announcements.view', 'announcements.create', 'announcements.update', 'announcements.delete',
                'events.view', 'events.create', 'events.update', 'events.delete',
                'gallery.view', 'gallery.create', 'gallery.update', 'gallery.delete',
                'videos.view', 'videos.create', 'videos.update', 'videos.delete',
                'media.manage',
                'pages.view', 'pages.create', 'pages.update', 'pages.delete',
                'messages.view',
            ],
            'Operator Akademik' => [
                'dashboard.view',
                'programs.view', 'programs.create', 'programs.update', 'programs.delete',
                'curriculums.view', 'curriculums.create', 'curriculums.update', 'curriculums.delete',
                'calendars.view', 'calendars.create', 'calendars.update', 'calendars.delete',
                'achievements.view', 'achievements.create', 'achievements.update', 'achievements.delete',
            ],
            'Operator Kesiswaan' => [
                'dashboard.view',
                'events.view', 'events.create', 'events.update', 'events.delete',
                'extracurriculars.view', 'extracurriculars.create', 'extracurriculars.update', 'extracurriculars.delete',
                'organizations.view', 'organizations.create', 'organizations.update', 'organizations.delete',
            ],
        ];
    }
}
