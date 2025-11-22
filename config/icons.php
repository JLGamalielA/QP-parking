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
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Standardized Icon Catalog
    |--------------------------------------------------------------------------
    |
    | This file contains the mapping of icon aliases to their respective
    | Font Awesome Classic Solid (fas) classes.
    |
    | Usage: <x-icon name="user" />
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
        'userEdit' => 'fas fa-user-pen',
        'userCheck' => 'fas fa-user-check',
        'userClock' => 'fas fa-user-clock',
        'userGear' => 'fas fa-user-gear',
        'userLock' => 'fas fa-user-lock',
        'userShield' => 'fas fa-user-shield',
        'users' => 'fas fa-users',
        'usersGear' => 'fas fa-users-gear',
        'userGroup' => 'fas fa-user-group',
        'userTie' => 'fas fa-user-tie',

        // ============================================================
        // ACTIONS (CRUD AND COMMON)
        // ============================================================
        'add' => 'fas fa-plus',
        'edit' => 'fas fa-pen-to-square',
        'delete' => 'fas fa-trash',
        'trash' => 'fas fa-trash',  // Alternative alias for delete
        'save' => 'fas fa-save',
        'cancel' => 'fas fa-xmark',
        'copy' => 'fas fa-copy',
        'cut' => 'fas fa-scissors',
        'paste' => 'fas fa-paste',
        'search' => 'fas fa-magnifying-glass',
        'view' => 'fas fa-eye',
        'hide' => 'fas fa-eye-slash',
        'send' => 'fas fa-paper-plane',
        'undo' => 'fas fa-rotate-left',
        'redo' => 'fas fa-rotate-right',
        'duplicate' => 'fas fa-clone',
        'share' => 'fas fa-share-nodes',
        'link' => 'fas fa-link',
        'unlink' => 'fas fa-link-slash',

        // ============================================================
        // STATUS, ALERTS AND NOTIFICATIONS
        // ============================================================
        'check' => 'fas fa-check',
        'success' => 'fas fa-check',
        'checkCircle' => 'fas fa-check-circle',
        'error' => 'fas fa-exclamation-triangle',
        'errorCircle' => 'fas fa-circle-exclamation',
        'info' => 'fas fa-info-circle',
        'infoCircle' => 'fas fa-circle-info',
        'warning' => 'fas fa-exclamation',
        'warningTriangle' => 'fas fa-triangle-exclamation',
        'question' => 'fas fa-question',
        'questionCircle' => 'fas fa-question-circle',
        'bell' => 'fas fa-bell',
        'bellSlash' => 'fas fa-bell-slash',
        'flag' => 'fas fa-flag',
        'bookmark' => 'fas fa-bookmark',
        'star' => 'fas fa-star',
        'starHalf' => 'fas fa-star-half-stroke',
        'heart' => 'fas fa-heart',
        'thumbsUp' => 'fas fa-thumbs-up',
        'thumbsDown' => 'fas fa-thumbs-down',

        // ============================================================
        // FILES AND DIRECTORIES
        // ============================================================
        'file' => 'fas fa-file',
        'fileLines' => 'fas fa-file-lines',
        'filePdf' => 'fas fa-file-pdf',
        'fileWord' => 'fas fa-file-word',
        'fileExcel' => 'fas fa-file-excel',
        'filePowerpoint' => 'fas fa-file-powerpoint',
        'fileImage' => 'fas fa-file-image',
        'fileVideo' => 'fas fa-file-video',
        'fileAudio' => 'fas fa-file-audio',
        'fileArchive' => 'fas fa-file-zipper',
        'fileCode' => 'fas fa-file-code',
        'fileCirclePlus' => 'fas fa-file-circle-plus',
        'fileCircleMinus' => 'fas fa-file-circle-minus',
        'folder' => 'fas fa-folder',
        'folderOpen' => 'fas fa-folder-open',
        'folderPlus' => 'fas fa-folder-plus',
        'folderMinus' => 'fas fa-folder-minus',
        'upload' => 'fas fa-upload',
        'download' => 'fas fa-download',
        'cloudUpload' => 'fas fa-cloud-arrow-up',
        'cloudDownload' => 'fas fa-cloud-arrow-down',

        // ============================================================
        // PROCESSES, CONFIGURATION AND LOADING
        // ============================================================
        'gear' => 'fas fa-cog',
        'gears' => 'fas fa-cogs',
        'sliders' => 'fas fa-sliders',
        'wrench' => 'fas fa-wrench',
        'screwdriver' => 'fas fa-screwdriver-wrench',
        'spinner' => 'fas fa-spinner',
        'circleNotch' => 'fas fa-circle-notch',
        'refresh' => 'fas fa-rotate-right',
        'sync' => 'fas fa-arrows-rotate',
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
        'grip' => 'fas fa-grip',
        'ellipsis' => 'fas fa-ellipsis',
        'ellipsisVertical' => 'fas fa-ellipsis-vertical',
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
        'anglesLeft' => 'fas fa-angles-left',
        'anglesRight' => 'fas fa-angles-right',
        'close' => 'fas fa-times',
        'times' => 'fas fa-times',
        'minus' => 'fas fa-minus',
        'plus' => 'fas fa-plus',
        'expand' => 'fas fa-expand',
        'compress' => 'fas fa-compress',
        'maximize' => 'fas fa-maximize',
        'minimize' => 'fas fa-minimize',

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
        'phoneFlip' => 'fas fa-phone-flip',
        'mobile' => 'fas fa-mobile-screen-button',
        'fax' => 'fas fa-fax',
        'message' => 'fas fa-message',
        'messages' => 'fas fa-messages',
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
        'listCheck' => 'fas fa-list-check',
        'tableCells' => 'fas fa-table-cells',
        'tableList' => 'fas fa-table-list',
        'grid' => 'fas fa-table-cells-large',
        'sort' => 'fas fa-sort',
        'sortUp' => 'fas fa-sort-up',
        'sortDown' => 'fas fa-sort-down',
        'sortAlphaDown' => 'fas fa-arrow-down-a-z',
        'sortAlphaUp' => 'fas fa-arrow-up-a-z',
        'sortNumericDown' => 'fas fa-arrow-down-1-9',
        'sortNumericUp' => 'fas fa-arrow-up-1-9',
        'filter' => 'fas fa-filter',
        'filterCircleXmark' => 'fas fa-filter-circle-xmark',
        'funnel' => 'fas fa-filter',

        // ============================================================
        // ACCESS AND SECURITY
        // ============================================================
        'lock' => 'fas fa-lock',
        'lockOpen' => 'fas fa-lock-open',
        'unlock' => 'fas fa-unlock',
        'key' => 'fas fa-key',
        'shield' => 'fas fa-shield',
        'shieldHalved' => 'fas fa-shield-halved',
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
        'chartColumn' => 'fas fa-chart-column',
        'chartSimple' => 'fas fa-chart-simple',
        'analytics' => 'fas fa-chart-line',
        'chartGantt' => 'fas fa-chart-gantt',
        'print' => 'fas fa-print',
        'fileExport' => 'fas fa-file-export',
        'fileImport' => 'fas fa-file-import',
        'export' => 'fas fa-file-export',
        'import' => 'fas fa-file-import',
        'database' => 'fas fa-database',
        'server' => 'fas fa-server',
        'hardDrive' => 'fas fa-hard-drive',

        // ============================================================
        // CALENDAR AND TIME
        // ============================================================
        'calendar' => 'fas fa-calendar',
        'calendarDays' => 'fas fa-calendar-days',
        'calendarCheck' => 'fas fa-calendar-check',
        'calendarPlus' => 'fas fa-calendar-plus',
        'calendarMinus' => 'fas fa-calendar-minus',
        'calendarXmark' => 'fas fa-calendar-xmark',

        // ============================================================
        // LOCATION AND MAPS
        // ============================================================
        'mapMarker' => 'fas fa-location-dot',
        'locationDot' => 'fas fa-location-dot',
        'locationPin' => 'fas fa-location-pin',
        'mapPin' => 'fas fa-map-pin',
        'map' => 'fas fa-map',
        'mapLocation' => 'fas fa-map-location',
        'mapLocationDot' => 'fas fa-map-location-dot',
        'globe' => 'fas fa-globe',
        'earthAmericas' => 'fas fa-earth-americas',
        'compass' => 'fas fa-compass',
        'route' => 'fas fa-route',

        // ============================================================
        // BUSINESS AND COMMERCE
        // ============================================================
        'store' => 'fas fa-store',
        'shop' => 'fas fa-shop',
        'bagShopping' => 'fas fa-bag-shopping',
        'basket' => 'fas fa-basket-shopping',
        'building' => 'fas fa-building',
        'briefcase' => 'fas fa-briefcase',
        'suitcase' => 'fas fa-suitcase',
        'handshake' => 'fas fa-handshake',
        'truck' => 'fas fa-truck',
        'box' => 'fas fa-box',
        'boxes' => 'fas fa-boxes-stacked',
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
        'paintbrush' => 'fas fa-paintbrush',
        'wand' => 'fas fa-wand-magic-sparkles',
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
    |
    | Defines icon colors based on context and background surface
    | according to CETAM institutional standards (Section 9.3.3).
    |
    */

    'colors' => [
        'primary' => '#1F2937',        // Light backgrounds (default)
        'secondary' => '#FFFFFF',      // Secondary backgrounds (#FB503B)
        'tertiary' => '#F2F4F6',       // Tertiary backgrounds (#31316A)
        'sidebar' => '#9CA3AF',        // Inactive sidebar (background #1F2937)
        'muted' => '#6B7280',          // Low emphasis or disabled
        'success' => '#FFFFFF',        // Green buttons (#10B981)
        'danger' => '#FFFFFF',         // Red buttons (#E11D48)
        'warning' => '#111827',        // Amber buttons (#FBA918)
        'info' => '#FFFFFF',           // Blue buttons (#1E90FF)
    ],

    /*
    |--------------------------------------------------------------------------
    | Icon Sizes
    |--------------------------------------------------------------------------
    |
    | Defines available size classes for icons.
    |
    */

    'sizes' => [
        'xs' => 'icon-xs',      // Extra small
        'sm' => 'icon-sm',      // Small
        'md' => '',             // Medium (default)
        'lg' => 'icon-lg',      // Large
        'xl' => 'icon-xl',      // Extra large
        '2x' => 'fa-2x',        // 2x size
        '3x' => 'fa-3x',        // 3x size
    ],
];
