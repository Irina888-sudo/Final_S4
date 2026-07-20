# Comment lancer l'app
php spark serve 

# Comment creer migrations
php spark make:migration CreateOperateursTable
php spark make:migration CreatePrefixesTable
php spark make:migration CreateClientsTable
php spark make:migration CreateTypesOperationTable
php spark make:migration CreateComptesTable
php spark make:migration CreateBaremesTable
php spark make:migration CreateTransactionsTable

# Comment migrer
php spark migrate
php spark migrate:refresh