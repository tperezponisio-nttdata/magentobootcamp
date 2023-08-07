require([
    'jquery',
    'uiRegistry'
], function ($, registry) {
    'use strict';

    // Usa el método 'get' del uiRegistry de Magento para recuperar el componente UI con el índice 'id_role'.
    // Una vez que se carga, se llama a la función de callback.
    registry.get('index = id_role', function (idRole) {

        // Una vez que se cargó idRole, cargo 'id_role_type'.
        registry.get('index = id_role_type', function (idRoleType) {

            console.log('Se cargaron las referencias de los select');

            // Guardo las opciones originales de id role type
            var allOptions = idRoleType.get('options');            

            // Agrego un escuchador de eventos al componente UI 'idRole' que escucha los cambios en su valor.
            idRole.on('value', function (value) {

                // Dependiendo del valor seleccionado de 'idRole', cambia las opciones de 'idRoleType'.
                switch (value) {
                    case '0':
                        console.log('Programador');
                        idRoleType.set('options', allOptions.toSpliced(3, 2));
                        break;

                    case '1':
                        console.log('Diseñador');
                        idRoleType.set('options', allOptions.toSpliced(0, 3));
                        break;

                    // Para cualquier otro valor de 'idRole', borra las opciones de 'idRoleType'.
                    default:
                        console.log('Nada Seleccionado');
                        idRoleType.set('options', []);
                        break;
                }
            });
        });
    });
});