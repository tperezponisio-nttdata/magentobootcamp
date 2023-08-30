require([
    'jquery',
    'uiRegistry'
], function ($, registry) {
    'use strict';

    // Usa el método 'get' del uiRegistry de Magento para recuperar el componente UI con el índice 'id_role'.
    // Una vez que se carga, se llama a la función de callback.
    registry.get('index = id_health_insurance_provider', function (idHealthInsuranceProvider) {

        // Una vez que se cargó idHealthInsuranceProvider, cargo 'id_health_insurance_provider'.
        registry.get('index = id_health_insurance_plan', function (idHealthInsurancePlan) {

            console.log('Se cargaron las referencias de los select');

            // Guardo las opciones originales de id role type
            var allOptions = idHealthInsurancePlan.get('options');

            // Agrego un escuchador de eventos al componente UI 'idHealthInsuranceProvider' que escucha los cambios en su valor.
            idHealthInsuranceProvider.on('value', function (value) {

                // Dependiendo del valor seleccionado de 'idHealthInsuranceProvider', cambia las opciones de 'idHealthInsurancePlan'.
                switch (value) {
                    case '1':
                        console.log('Swiss Medical');
                        idHealthInsurancePlan.set('options', allOptions.toSpliced(3, 7));
                        break;

                    case '2':
                        console.log('OSDE');
                        idHealthInsurancePlan.set('options', (allOptions.toSpliced(0, 3)).toSpliced(3, 4));
                        break;

                    case '3':
                        console.log('Galeno');
                        idHealthInsurancePlan.set('options', allOptions.toSpliced(0, 6));
                        break;

                    // Para cualquier otro valor de 'idHealthInsuranceProvider', borra las opciones de 'idHealthInsurancePlan'.
                    default:
                        console.log('Nada Seleccionado');
                        idHealthInsurancePlan.set('options', []);
                        break;
                }
            });
        });
    });
});