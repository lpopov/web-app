imports:
    - { resource: parameters.yml }
    - { resource: security.yml }
    - { resource: services.yml }

# Put parameters here that don't need to change on each machine where the app is deployed
# http://symfony.com/doc/current/best_practices/configuration.html#application-related-configuration
parameters:
    locale: en

framework:
    #esi:             ~
    #translator:      { fallbacks: ["%locale%"] }
    secret:          "%secret%"
    router:
        resource: "%kernel.root_dir%/config/routing.yml"
        strict_requirements: ~
    form:            ~
    csrf_protection: ~
    validation:      { enable_annotations: true }
    #serializer:      { enable_annotations: true }
    templating:
        engines: ['twig']
        #assets_version: SomeVersionScheme
    default_locale:  "%locale%"
    trusted_hosts:   ~
    trusted_proxies: ~
    session:
        # handler_id set to null will use default session handler from php.ini
        handler_id:  ~
    fragments:       ~
    http_method_override: true

# Twig Configuration
twig:
    debug:            "%kernel.debug%"
    strict_variables: "%kernel.debug%"
    form:
        #resources: ['bootstrap_3_layout.html.twig']
        resources: ['bootstrap_3_horizontal_layout.html.twig']

# Assetic Configuration
assetic:
    debug:          "%kernel.debug%"
    use_controller: false
    bundles:        [ ]
    #java: /usr/bin/java
    filters:
        cssrewrite: ~
        #closure:
        #    jar: "%kernel.root_dir%/Resources/java/compiler.jar"
        #yui_css:
        #    jar: "%kernel.root_dir%/Resources/java/yuicompressor-2.4.7.jar"

# Doctrine Configuration
doctrine:
    dbal:
        driver:   pdo_mysql
        host:     "%database_host%"
        port:     "%database_port%"
        dbname:   "%database_name%"
        user:     "%database_user%"
        password: "%database_password%"
        charset:  UTF8

    orm:
        auto_generate_proxy_classes: "%kernel.debug%"
        naming_strategy: doctrine.orm.naming_strategy.underscore
        auto_mapping: true

# Swiftmailer Configuration
swiftmailer:
    transport: "%mailer_transport%"
    host:      "%mailer_host%"
    username:  "%mailer_user%"
    password:  "%mailer_password%"
    spool:     { type: memory }

stof_doctrine_extensions:
    default_locale: en_US
    orm:
        default:
            sluggable: true
            timestampable: true

heidi_labs_sauth:
    home: devhuman_homepage #route name for the app entry point when the user is logged in (redirect after successfull auth)
    user_class: AppBundle\Entity\User #this is the default value
    credentials_class: AppBundle\Entity\Credentials #this is the default value
    allow_registration: true #this is true by default
    services:
        github:
            class: HeidiLabs\SauthBundle\OAuthService\GithubService
            config:
                client_name: {{ github.client_name }}
                client_id: {{ github.client_id }}
                client_secret: {{ github.client_secret }}
                callback_url: {{ github.callback_url }}

knp_paginator:
    page_range: 3                      # default page range used in pagination control
    default_options:
        page_name: page                # page query parameter name
        sort_field_name: sort          # sort field query parameter name
        sort_direction_name: direction # sort direction query parameter name
        distinct: true                 # ensure distinct results, useful when ORM queries are using GROUP BY statements
    template:
        pagination: KnpPaginatorBundle:Pagination:twitter_bootstrap_v3_pagination.html.twig     # sliding pagination controls template
        sortable: KnpPaginatorBundle:Pagination:sortable_link.html.twig # sort link template
