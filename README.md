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
php spark make:migration CreatePromotionConfigTable
php spark make:migration CreateEpargneTable

# Comment migrer
php spark migrate
php spark migrate:refresh

# insertion des donnees
php spark db:seed InitialDataSeeder;


# creer tous les model
php spark make:model OperateurModel
php spark make:model PrefixeModel
php spark make:model ClientModel
php spark make:model CompteModel
php spark make:model TypeOperationModel
php spark make:model BaremeModel
php spark make:model TransactionModel
