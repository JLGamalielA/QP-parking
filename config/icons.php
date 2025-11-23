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
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Definition of the standardized icon catalog mapping aliases to Font Awesome classes. |
 * 
 * - ID: 2 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Full rollback of icon classes to Font Awesome 5 standard to ensure compatibility with Volt template. |
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Standardized Icon Catalog (Font Awesome 5 Compatible)
    |--------------------------------------------------------------------------
    |
    | This file contains the mapping of icon aliases to their respective
    | Font Awesome Classic Solid (fas) classes compatible with FA version 5.
    |
    | Usage: <x-qpk-icon name="user" />
    | Result: <i class="fas fa-user" aria-hidden="true"></i>
    |
    */

    'icons' => [
        // ============================================================
        // USERS AND ROLES
        // ============================================================
        'user' => 'fas fa-user',
        'userCircle' => 'fas fa-user-circle',
        'userPlus' => 'fas fa-user-plus',
        'userMinus' => 'fas fa-user-minus',
        'userEdit' => 'fas fa-user-edit', // FA6: fa-user-pen -> FA5: fa-user-edit
        'userCheck' => 'fas fa-user-check',
        'userClock' => 'fas fa-user-clock',
        'userGear' => 'fas fa-user-cog', // FA6: fa-user-gear -> FA5: fa-user-cog
        'userLock' => 'fas fa-user-lock',
        'userShield' => 'fas fa-user-shield',
        'users' => 'fas fa-users',
        'usersGear' => 'fas fa-users-cog', // FA6: fa-users-gear -> FA5: fa-users-cog
        'userGroup' => 'fas fa-users', // FA6: fa-user-group -> FA5: fa-users
        'userTie' => 'fas fa-user-tie',

        // ============================================================
        // ACTIONS (CRUD AND COMMON)
        // ============================================================
        'add' => 'fas fa-plus',
        'edit' => 'fas fa-edit', // FA6: fa-pen-to-square -> FA5: fa-edit
        'delete' => 'fas fa-trash',
        'trash' => 'fas fa-trash',
        'save' => 'fas fa-save',
        'cancel' => 'fas fa-times', // FA6: fa-xmark -> FA5: fa-times
        'copy' => 'fas fa-copy',
        'cut' => 'fas fa-scissors',
        'paste' => 'fas fa-paste',
        'search' => 'fas fa-search', // FA6: fa-magnifying-glass -> FA5: fa-search
        'view' => 'fas fa-eye',
        'hide' => 'fas fa-eye-slash',
        'send' => 'fas fa-paper-plane',
        'undo' => 'fas fa-undo', // FA6: fa-rotate-left -> FA5: fa-undo
        'redo' => 'fas fa-redo', // FA6: fa-rotate-right -> FA5: fa-redo
        'duplicate' => 'fas fa-clone',
        'share' => 'fas fa-share-alt', // FA6: fa-share-nodes -> FA5: fa-share-alt
        'link' => 'fas fa-link',
        'unlink' => 'fas fa-unlink', // FA6: fa-link-slash -> FA5: fa-unlink

        // ============================================================
        // STATUS, ALERTS AND NOTIFICATIONS
        // ============================================================
        'check' => 'fas fa-check',
        'success' => 'fas fa-check',
        'checkCircle' => 'fas fa-check-circle',
        'error' => 'fas fa-exclamation-triangle',
        'errorCircle' => 'fas fa-exclamation-circle', // FA6: fa-circle-exclamation -> FA5: fa-exclamation-circle
        'info' => 'fas fa-info-circle',
        'infoCircle' => 'fas fa-info-circle', // FA6: fa-circle-info -> FA5: fa-info-circle
        'warning' => 'fas fa-exclamation',
        'warningTriangle' => 'fas fa-exclamation-triangle', // FA6: fa-triangle-exclamation -> FA5: fa-exclamation-triangle
        'question' => 'fas fa-question',
        'questionCircle' => 'fas fa-question-circle',
        'bell' => 'fas fa-bell',
        'bellSlash' => 'fas fa-bell-slash',
        'flag' => 'fas fa-flag',
        'bookmark' => 'fas fa-bookmark',
        'star' => 'fas fa-star',
        'starHalf' => 'fas fa-star-half-alt', // FA6: fa-star-half-stroke -> FA5: fa-star-half-alt
        'heart' => 'fas fa-heart',
        'thumbsUp' => 'fas fa-thumbs-up',
        'thumbsDown' => 'fas fa-thumbs-down',

        // ============================================================
        // FILES AND DIRECTORIES
        // ============================================================
        'file' => 'fas fa-file',
        'fileLines' => 'fas fa-file-alt', // FA6: fa-file-lines -> FA5: fa-file-alt
        'filePdf' => 'fas fa-file-pdf',
        'fileWord' => 'fas fa-file-word',
        'fileExcel' => 'fas fa-file-excel',
        'filePowerpoint' => 'fas fa-file-powerpoint',
        'fileImage' => 'fas fa-file-image',
        'fileVideo' => 'fas fa-file-video',
        'fileAudio' => 'fas fa-file-audio',
        'fileArchive' => 'fas fa-file-archive', // FA6: fa-file-zipper -> FA5: fa-file-archive
        'fileCode' => 'fas fa-file-code',
        'fileCirclePlus' => 'fas fa-plus-circle', // Replacement for file-circle-plus
        'fileCircleMinus' => 'fas fa-minus-circle', // Replacement for file-circle-minus
        'folder' => 'fas fa-folder',
        'folderOpen' => 'fas fa-folder-open',
        'folderPlus' => 'fas fa-folder-plus',
        'folderMinus' => 'fas fa-folder-minus',
        'upload' => 'fas fa-upload',
        'download' => 'fas fa-download',
        'cloudUpload' => 'fas fa-cloud-upload-alt', // FA6: fa-cloud-arrow-up -> FA5: fa-cloud-upload-alt
        'cloudDownload' => 'fas fa-cloud-download-alt', // FA6: fa-cloud-arrow-down -> FA5: fa-cloud-download-alt

        // ============================================================
        // PROCESSES, CONFIGURATION AND LOADING
        // ============================================================
        'gear' => 'fas fa-cog',
        'gears' => 'fas fa-cogs',
        'sliders' => 'fas fa-sliders-h', // FA6: fa-sliders -> FA5: fa-sliders-h
        'wrench' => 'fas fa-wrench',
        'screwdriver' => 'fas fa-tools', // Replacement for screwdriver-wrench
        'spinner' => 'fas fa-spinner',
        'circleNotch' => 'fas fa-circle-notch',
        'refresh' => 'fas fa-sync-alt', // FA6: fa-rotate-right -> FA5: fa-sync-alt
        'sync' => 'fas fa-sync', // FA6: fa-arrows-rotate -> FA5: fa-sync
        'power' => 'fas fa-power-off',
        'plug' => 'fas fa-plug',
        'battery' => 'fas fa-battery-full',
        'clock' => 'fas fa-clock',
        'hourglass' => 'fas fa-hourglass-half',
        'stopwatch' => 'fas fa-stopwatch',

        // ============================================================
        // NAVIGATION AND INTERFACE
        // ============================================================
        'home' => 'fas fa-home',
        'dashboard' => 'fas fa-tachometer-alt',
        'menu' => 'fas fa-bars',
        'grip' => 'fas fa-grip-horizontal', // FA6: fa-grip -> FA5: fa-grip-horizontal
        'ellipsis' => 'fas fa-ellipsis-h', // FA6: fa-ellipsis -> FA5: fa-ellipsis-h
        'ellipsisVertical' => 'fas fa-ellipsis-v', // FA6: fa-ellipsis-vertical -> FA5: fa-ellipsis-v
        'back' => 'fas fa-arrow-left',
        'forward' => 'fas fa-arrow-right',
        'arrowUp' => 'fas fa-arrow-up',
        'arrowDown' => 'fas fa-arrow-down',
        'chevronLeft' => 'fas fa-chevron-left',
        'chevronRight' => 'fas fa-chevron-right',
        'chevronUp' => 'fas fa-chevron-up',
        'chevronDown' => 'fas fa-chevron-down',
        'caretLeft' => 'fas fa-caret-left',
        'caretRight' => 'fas fa-caret-right',
        'caretUp' => 'fas fa-caret-up',
        'caretDown' => 'fas fa-caret-down',
        'angleLeft' => 'fas fa-angle-left',
        'angleRight' => 'fas fa-angle-right',
        'angleUp' => 'fas fa-angle-up',
        'angleDown' => 'fas fa-angle-down',
        'anglesLeft' => 'fas fa-angle-double-left', // FA6: fa-angles-left -> FA5: fa-angle-double-left
        'anglesRight' => 'fas fa-angle-double-right', // FA6: fa-angles-right -> FA5: fa-angle-double-right
        'close' => 'fas fa-times',
        'times' => 'fas fa-times',
        'minus' => 'fas fa-minus',
        'plus' => 'fas fa-plus',
        'expand' => 'fas fa-expand',
        'compress' => 'fas fa-compress',
        'maximize' => 'fas fa-expand-arrows-alt', // FA6: fa-maximize -> FA5: fa-expand-arrows-alt
        'minimize' => 'fas fa-compress-arrows-alt', // FA6: fa-minimize -> FA5: fa-compress-arrows-alt

        // ============================================================
        // FINANCE AND TRANSACTIONS
        // ============================================================
        'money' => 'fas fa-dollar-sign',
        'coins' => 'fas fa-coins',
        'moneyBill' => 'fas fa-money-bill',
        'moneyBillWave' => 'fas fa-money-bill-wave',
        'creditCard' => 'fas fa-credit-card',
        'wallet' => 'fas fa-wallet',
        'cashRegister' => 'fas fa-cash-register',
        'receipt' => 'fas fa-receipt',
        'invoice' => 'fas fa-file-invoice',
        'invoiceDollar' => 'fas fa-file-invoice-dollar',
        'cartShopping' => 'fas fa-shopping-cart',
        'cartPlus' => 'fas fa-cart-plus',
        'cartArrowDown' => 'fas fa-cart-arrow-down',
        'tag' => 'fas fa-tag',
        'tags' => 'fas fa-tags',
        'percent' => 'fas fa-percent',
        'percentage' => 'fas fa-percentage',

        // ============================================================
        // COMMUNICATION
        // ============================================================
        'email' => 'fas fa-envelope',
        'envelopeOpen' => 'fas fa-envelope-open',
        'inbox' => 'fas fa-inbox',
        'paperPlane' => 'fas fa-paper-plane',
        'phone' => 'fas fa-phone',
        'phoneFlip' => 'fas fa-phone-alt', // FA6: fa-phone-flip -> FA5: fa-phone-alt
        'mobile' => 'fas fa-mobile-alt', // FA6: fa-mobile-screen-button -> FA5: fa-mobile-alt
        'fax' => 'fas fa-fax',
        'message' => 'fas fa-comment-alt', // FA6: fa-message -> FA5: fa-comment-alt
        'messages' => 'fas fa-comments',
        'comment' => 'fas fa-comment',
        'comments' => 'fas fa-comments',
        'chat' => 'fas fa-comment',
        'video' => 'fas fa-video',
        'videoSlash' => 'fas fa-video-slash',
        'microphone' => 'fas fa-microphone',
        'microphoneSlash' => 'fas fa-microphone-slash',
        'rss' => 'fas fa-rss',
        'podcast' => 'fas fa-podcast',
        'bullhorn' => 'fas fa-bullhorn',
        'at' => 'fas fa-at',

        // ============================================================
        // LISTS, SORTING AND FILTERS
        // ============================================================
        'list' => 'fas fa-list',
        'listUl' => 'fas fa-list-ul',
        'listOl' => 'fas fa-list-ol',
        'listCheck' => 'fas fa-tasks', // FA6: fa-list-check -> FA5: fa-tasks
        'tableCells' => 'fas fa-th', // FA6: fa-table-cells -> FA5: fa-th
        'tableList' => 'fas fa-th-list', // FA6: fa-table-list -> FA5: fa-th-list
        'grid' => 'fas fa-th-large', // FA6: fa-table-cells-large -> FA5: fa-th-large
        'sort' => 'fas fa-sort',
        'sortUp' => 'fas fa-sort-up',
        'sortDown' => 'fas fa-sort-down',
        'sortAlphaDown' => 'fas fa-sort-alpha-down', // FA6: fa-arrow-down-a-z -> FA5: fa-sort-alpha-down
        'sortAlphaUp' => 'fas fa-sort-alpha-up', // FA6: fa-arrow-up-a-z -> FA5: fa-sort-alpha-up
        'sortNumericDown' => 'fas fa-sort-numeric-down', // FA6: fa-arrow-down-1-9 -> FA5: fa-sort-numeric-down
        'sortNumericUp' => 'fas fa-sort-numeric-up', // FA6: fa-arrow-up-1-9 -> FA5: fa-sort-numeric-up
        'filter' => 'fas fa-filter',
        'filterCircleXmark' => 'fas fa-filter', // No direct equivalent, fallback to filter
        'funnel' => 'fas fa-filter',

        // ============================================================
        // ACCESS AND SECURITY
        // ============================================================
        'lock' => 'fas fa-lock',
        'lockOpen' => 'fas fa-lock-open',
        'unlock' => 'fas fa-unlock',
        'key' => 'fas fa-key',
        'shield' => 'fas fa-shield-alt', // FA6: fa-shield -> FA5: fa-shield-alt
        'shieldHalved' => 'fas fa-shield-alt', // FA6: fa-shield-halved -> FA5: fa-shield-alt
        'userShield' => 'fas fa-user-shield',
        'fingerprint' => 'fas fa-fingerprint',
        'idCard' => 'fas fa-id-card',
        'idBadge' => 'fas fa-id-badge',
        'signIn' => 'fas fa-sign-in-alt',
        'signOut' => 'fas fa-sign-out-alt',
        'arrowRightToBracket' => 'fas fa-sign-in-alt',
        'arrowRightFromBracket' => 'fas fa-sign-out-alt',
        'doorOpen' => 'fas fa-door-open',
        'doorClosed' => 'fas fa-door-closed',

        // ============================================================
        // REPORTS AND ANALYTICS
        // ============================================================
        'chartBar' => 'fas fa-chart-bar',
        'chartLine' => 'fas fa-chart-line',
        'chartPie' => 'fas fa-chart-pie',
        'chartArea' => 'fas fa-chart-area',
        'chartColumn' => 'fas fa-chart-bar', // FA6: fa-chart-column -> FA5: fa-chart-bar
        'chartSimple' => 'fas fa-chart-bar', // FA6: fa-chart-simple -> FA5: fa-chart-bar
        'analytics' => 'fas fa-chart-line',
        'chartGantt' => 'fas fa-stream', // FA6: fa-chart-gantt -> FA5: fa-stream (approx)
        'print' => 'fas fa-print',
        'fileExport' => 'fas fa-file-export',
        'fileImport' => 'fas fa-file-import',
        'export' => 'fas fa-file-export',
        'import' => 'fas fa-file-import',
        'database' => 'fas fa-database',
        'server' => 'fas fa-server',
        'hardDrive' => 'fas fa-hdd', // FA6: fa-hard-drive -> FA5: fa-hdd

        // ============================================================
        // CALENDAR AND TIME
        // ============================================================
        'calendar' => 'fas fa-calendar',
        'calendarDays' => 'fas fa-calendar-alt', // FA6: fa-calendar-days -> FA5: fa-calendar-alt
        'calendarCheck' => 'fas fa-calendar-check',
        'calendarPlus' => 'fas fa-calendar-plus',
        'calendarMinus' => 'fas fa-calendar-minus',
        'calendarXmark' => 'fas fa-calendar-times', // FA6: fa-calendar-xmark -> FA5: fa-calendar-times

        // ============================================================
        // LOCATION AND MAPS
        // ============================================================
        'mapMarker' => 'fas fa-map-marker-alt', // FA6: fa-location-dot -> FA5: fa-map-marker-alt
        'locationDot' => 'fas fa-map-marker-alt', // FA6: fa-location-dot -> FA5: fa-map-marker-alt
        'locationPin' => 'fas fa-thumbtack', // FA6: fa-location-pin -> FA5: fa-thumbtack (approx)
        'mapPin' => 'fas fa-map-pin',
        'map' => 'fas fa-map',
        'mapLocation' => 'fas fa-map-marked', // FA6: fa-map-location -> FA5: fa-map-marked
        'mapLocationDot' => 'fas fa-map-marked-alt', // FA6: fa-map-location-dot -> FA5: fa-map-marked-alt
        'globe' => 'fas fa-globe',
        'earthAmericas' => 'fas fa-globe-americas', // FA6: fa-earth-americas -> FA5: fa-globe-americas
        'compass' => 'fas fa-compass',
        'route' => 'fas fa-route',

        // ============================================================
        // BUSINESS AND COMMERCE
        // ============================================================
        'store' => 'fas fa-store',
        'shop' => 'fas fa-store-alt', // FA6: fa-shop -> FA5: fa-store-alt
        'bagShopping' => 'fas fa-shopping-bag', // FA6: fa-bag-shopping -> FA5: fa-shopping-bag
        'basket' => 'fas fa-shopping-basket', // FA6: fa-basket-shopping -> FA5: fa-shopping-basket
        'building' => 'fas fa-building',
        'briefcase' => 'fas fa-briefcase',
        'suitcase' => 'fas fa-suitcase',
        'handshake' => 'fas fa-handshake',
        'truck' => 'fas fa-truck',
        'box' => 'fas fa-box',
        'boxes' => 'fas fa-boxes', // FA6: fa-boxes-stacked -> FA5: fa-boxes
        'warehouse' => 'fas fa-warehouse',
        'industry' => 'fas fa-industry',
        'factory' => 'fas fa-industry',

        // ============================================================
        // MISCELLANEOUS
        // ============================================================
        'image' => 'fas fa-image',
        'images' => 'fas fa-images',
        'camera' => 'fas fa-camera',
        'cameraRetro' => 'fas fa-camera-retro',
        'trophy' => 'fas fa-trophy',
        'award' => 'fas fa-award',
        'medal' => 'fas fa-medal',
        'gift' => 'fas fa-gift',
        'palette' => 'fas fa-palette',
        'paintbrush' => 'fas fa-paint-brush', // FA6: fa-paintbrush -> FA5: fa-paint-brush
        'wand' => 'fas fa-magic', // FA6: fa-wand-magic-sparkles -> FA5: fa-magic
        'lightbulb' => 'fas fa-lightbulb',
        'bolt' => 'fas fa-bolt',
        'fire' => 'fas fa-fire',
        'snowflake' => 'fas fa-snowflake',
        'sun' => 'fas fa-sun',
        'moon' => 'fas fa-moon',
        'cloud' => 'fas fa-cloud',
        'umbrella' => 'fas fa-umbrella',
    ],

    /*
    |--------------------------------------------------------------------------
    | Icon Colors per Surface
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Icon Sizes
    |--------------------------------------------------------------------------
    */
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
