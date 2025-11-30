<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: icons.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of the standardized icon catalog mapping aliases to Font Awesome classes. |
 * 
 * - ID: 2 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Full rollback of icon classes to Font Awesome 5 standard to ensure compatibility with Volt template. |
 */

return [
    'icons' => [
        // Navigation & Interface
        'nav' => [
            'home'          => 'fa-solid fa-house',
            'dashboard'     => 'fa-solid fa-gauge-high',
            'menu'          => 'fa-solid fa-bars',
            'back'          => 'fa-solid fa-arrow-left',
            'forward'       => 'fa-solid fa-arrow-right',
            'up'            => 'fa-solid fa-arrow-up',
            'down'          => 'fa-solid fa-arrow-down',
            'close'         => 'fa-solid fa-xmark',
            'external_link' => 'fa-solid fa-arrow-up-right-from-square',
        ],

        // User & Authentication
        'user' => [
            'profile' => 'fa-solid fa-user',
            'avatar'  => 'fa-solid fa-circle-user',
            'add'     => 'fa-solid fa-user-plus',
            'remove'  => 'fa-solid fa-user-minus',
            'list'    => 'fa-solid fa-users',
            'admin'   => 'fa-solid fa-user-tie',
            'group'   => 'fa-solid fa-user-group',
            'gear'    => 'fa-solid fa-users-gear',
        ],
        'auth' => [
            'login'  => 'fa-solid fa-right-to-bracket',
            'logout' => 'fa-solid fa-right-from-bracket',
        ],

        // Common Actions
        'action' => [
            'create'    => 'fa-solid fa-plus',
            'edit'      => 'fa-solid fa-pen-to-square',
            'delete'    => 'fa-solid fa-trash',
            'view'      => 'fa-solid fa-eye',
            'save'      => 'fa-solid fa-floppy-disk',
            'cancel'    => 'fa-solid fa-xmark',
            'send'      => 'fa-solid fa-paper-plane',
            'download'  => 'fa-solid fa-download',
            'upload'    => 'fa-solid fa-upload',
            'search'    => 'fa-solid fa-magnifying-glass',
            'refresh'   => 'fa-solid fa-arrows-rotate',
            'filter'    => 'fa-solid fa-filter',
            'sort'      => 'fa-solid fa-sort',
            'sort_up'   => 'fa-solid fa-sort-up',
            'sort_down' => 'fa-solid fa-sort-down',
            'scan'      => 'fa-solid fa-qrcode',
            'flag'      => 'fa-solid fa-flag',
            'more'      => 'fa-solid fa-ellipsis',
        ],

        // States
        'state' => [
            'success'     => 'fa-solid fa-circle-check',
            'error'       => 'fa-solid fa-circle-xmark',
            'warning'     => 'fa-solid fa-triangle-exclamation',
            'info'        => 'fa-solid fa-circle-info',
            'pending'     => 'fa-solid fa-clock',
            'in_progress' => 'fa-solid fa-spinner',
            'sync'        => 'fa-solid fa-sync',
            'approved'    => 'fa-solid fa-thumbs-up',
            'rejected'    => 'fa-solid fa-thumbs-down',
            'canceled'    => 'fa-solid fa-ban',
            'finished'    => 'fa-solid fa-flag-checkered',
            'started'     => 'fa-solid fa-play',
        ],

        // Files & Documents
        'file' => [
            'generic'    => 'fa-solid fa-file',
            'pdf'        => 'fa-solid fa-file-pdf',
            'word'       => 'fa-solid fa-file-word',
            'excel'      => 'fa-solid fa-file-excel',
            'image'      => 'fa-solid fa-file-image',
            'csv'        => 'fa-solid fa-file-csv',
            'attachment' => 'fa-solid fa-paperclip',
        ],
        'folder' => [
            'closed' => 'fa-solid fa-folder',
            'open'   => 'fa-solid fa-folder-open',
        ],

        // Frequent Domains
        'geo' => [
            'location' => 'fa-solid fa-location-dot',
        ],
        'money' => [
            'currency' => 'fa-solid fa-dollar-sign',
            'coins'    => 'fa-solid fa-coins',
            'card'     => 'fa-solid fa-credit-card',
            'invoice'  => 'fa-solid fa-file-invoice-dollar',
        ],

        // Security & Access (Agregado para Lectores/Usuarios especiales)
        'access' => [
            'key' => 'fa-solid fa-key',
            'shield' => 'fa-solid fa-shield-halved',
        ],

        // Messaging (Agregado para Solicitudes)
        'msg' => [
            'inbox' => 'fa-solid fa-inbox',
            'email' => 'fa-solid fa-envelope',
            'phone' => 'fa-solid fa-phone',
        ],

        // Support (Fallback)
        'support' => [
            'help' => 'fa-solid fa-circle-question',
        ],
    ],

    'colors' => [
        'primary' => '#1F2937',
        'secondary' => '#FFFFFF',
        'tertiary' => '#F2F4F6',
        'sidebar' => '#9CA3AF',
        'muted' => '#6B7280',
        'success' => '#FFFFFF',
        'danger' => '#FFFFFF',
        'warning' => '#111827',
        'info' => '#FFFFFF',
    ],

    'sizes' => [
        'xs' => 'icon-xs',
        'sm' => 'icon-sm',
        'md' => '',
        'lg' => 'icon-lg',
        'xl' => 'icon-xl',
        '2x' => 'fa-2x',
        '3x' => 'fa-3x',
    ],
];
