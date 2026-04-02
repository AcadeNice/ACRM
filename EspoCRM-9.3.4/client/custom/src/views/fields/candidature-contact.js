define('custom:views/fields/candidature-contact', ['views/fields/link'], function (Dep) {
    return class extends Dep {
        getSelectFilters() {
            const valueList = ['candidat', 'etudiant', 'alumni'];

            return {
                contactRoles: {
                    type: 'arrayAnyOf',
                    attribute: 'contactRoles',
                    value: valueList,
                    data: {
                        type: 'anyOf',
                        valueList: valueList
                    }
                }
            };
        }
    };
});
