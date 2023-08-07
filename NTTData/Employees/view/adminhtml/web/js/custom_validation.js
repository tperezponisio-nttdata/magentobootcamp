require([
    'Magento_Ui/js/lib/validation/validator',
    'jquery'
], function (validator, $) {
    validator.addRule(
        'validate-letters-custom',
        function (value) {
            return /^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/.test(value);
        }
        , $.mage.__('Please enter only letters (tildes incluidos).')
    );

    validator.addRule(
        'validate-age-more-than-18',
        function (value) {
            var dob = new Date(value);
            var today = new Date();
            // aca saca la edad en años pelados, sin contar meses y dias
            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();

            // si hay diferencia de meses o si no hay diferencia de meses pero hay diferencia de dias, le resto a la edad en años
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            // retorno la evaluacion de edad mayor o igual a 18
            return age >= 18;
        }
        , $.mage.__('You must be 18 years old or older.')
    );
});
