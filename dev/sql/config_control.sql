INSERT INTO `config_control` (
        `params_name`,
        `params_value`,
        `value_type`,
        `group_access`
    )
VALUES ('CFG_DEBUG', '1', 'boolean', '5'),
    ('CFG_SECURE_COOKIE', '0', 'boolean', '5'),
    (
        'CFG_VIEW_RECONSTRUCTION_PAGE',
        '0',
        'boolean',
        '5'
    ),
    (
        'CFG_MAIL_FROM',
        'noreply@your-domain.com',
        'string',
        '5'
    ),
    (
        'CFG_REPLY_TO',
        'site.owner@email.com',
        'string',
        '5'
    ),
    ('CFG_REPLY_TO_NAME', '«AIW cms»', 'string', '5'),
    (
        'CFG_ACCOUNTANT_EMAIL',
        'accountant@email.com',
        'string',
        '5'
    ),
    (
        'CFG_TECH_SUPPORT_USER_EMAIL',
        'site.admin@email.com',
        'string',
        '5'
    ),
    ('CFG_PAGINATION', '18', 'int', '5'),
    ('CFG_HISTORY_PAGINATION', '25', 'int', '5'),
    ('CFG_IMAGES_LIST_PAGINATION', '24', 'int', '5'),
    ('CFG_MIN_SESSION_TIME', '900', 'int', '5'),
    ('CFG_MAX_SESSION_TIME', '1209600', 'int', '5'),
    ('CFG_USER_PHONE_LEN', '12', 'int', '5'),
    ('CFG_TEXTAREA_ROWS', '7', 'int', '5'),
    ('CFG_MIN_INTEGER_LEN', '1', 'int', '5'),
    ('CFG_MAX_INTEGER_LEN', '12', 'int', '5'),
    ('CFG_MIN_PASS_LEN', '6', 'int', '5'),
    ('CFG_MAX_PASS_LEN', '32', 'int', '5'),
    ('CFG_MIN_NAME_LEN', '2', 'int', '5'),
    ('CFG_MAX_NAME_LEN', '32', 'int', '5'),
    ('CFG_MIN_FILTER_NAME_LEN', '3', 'int', '5'),
    ('CFG_MAX_FILTER_NAME_LEN', '64', 'int', '5'),
    ('CFG_MIN_EMAIL_LEN', '8', 'int', '5'),
    ('CFG_MAX_EMAIL_LEN', '64', 'int', '5'),
    ('CFG_MIN_TICKET_ANSWER_LEN', '2', 'int', '5'),
    ('CFG_MAX_TICKET_ANSWER_LEN', '1024', 'int', '5'),
    ('CFG_USER_ACTIVATION_TIME', '172800', 'int', '5'),
    ('CFG_NOTE_ENABLED_TO', '300', 'int', '5'),
    ('CFG_NEW_TICKET_TIME', '86400', 'int', '5'),
    ('CFG_DATE_FORMAT', 'd.m.Y', 'string', '5'),
    (
        'CFG_DATE_TIME_FORMAT',
        'd.m.Y H:i',
        'string',
        '5'
    ),
    (
        'CFG_DATE_TIME_SECONDS_FORMAT',
        'd.m.Y H:i:s',
        'string',
        '5'
    ),
    (
        'CFG_DATE_TIME_MYSQL_FORMAT',
        'Y-m-d H:i:s',
        'string',
        '5'
    ),
    ('CFG_SCHEMA_TIME_FORMAT', 'Y-m-d', 'string', '5'),
    ('CFG_MIN_REF_CODE_LEN', '4', 'int', '5'),
    ('CFG_MAX_REF_CODE_LEN', '8', 'int', '5'),
    ('CFG_TIME_REFRESH', '300', 'int', '5'),
    (
        'CFG_ENABLED_VIEW_LOG_TIME',
        '7889400',
        'int',
        '5'
    ),
    ('CFG_MAX_IMAGES_SIZE', '8388608', 'int', '5'),
    ('CFG_IMAGES_PATH', 'img', 'string', '5'),
    ('CFG_USER_AVATAR_PATH', 'avatar', 'string', '5'),
    ('CFG_MAX_THUMB_SIZE', '255', 'int', '5'),
    ('CFG_MIN_HEADING_LEN', '8', 'int', '5'),
    ('CFG_MAX_HEADING_LEN', '256', 'int', '5'),
    ('CFG_MIN_INTRO_TEXT_LEN', '12', 'int', '5'),
    ('CFG_MAX_INTRO_TEXT_LEN', '512', 'int', '5'),
    ('CFG_MIN_TEXT_LEN', '256', 'int', '5'),
    ('CFG_MAX_TEXT_LEN', '50000', 'int', '5'),
    (
        'CFG_MIN_ITEM_CONTROLLER_URL_LEN',
        '3',
        'int',
        '5'
    ),
    (
        'CFG_MAX_ITEM_CONTROLLER_URL_LEN',
        '28',
        'int',
        '5'
    ),
    ('CFG_INTRO_IMAGE_PATH', 'intro', 'string', '5'),
    ('CFG_INTRO_IMAGE_WIDTH', '790', 'int', '5'),
    ('CFG_INTRO_IMAGE_HEIGHT', '444', 'int', '5'),
    ('CFG_AVATAR_SIDE_SIZE', '255', 'int', '5'),
    ('CFG_MIN_GET_VALUES_LEN', '1', 'int', '5'),
    ('CFG_MAX_GET_VALUES_LEN', '32', 'int', '5'),
    ('CFG_MIN_LINK_LEN', '8', 'int', '5'),
    ('CFG_MAX_LINK_LEN', '256', 'int', '5');
