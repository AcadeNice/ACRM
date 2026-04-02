define('custom:views/dashlets/new-candidates', ['views/dashlets/abstract/record-list'], function (Dep) {
    return Dep.extend({
        name: 'NewCandidates',
        scope: 'Contact',

        getSearchData: function () {
            return {
                advanced: {
                    contactRoles: {
                        type: 'arrayAnyOf',
                        field: 'contactRoles',
                        value: ['candidat'],
                        data: {
                            type: 'anyOf',
                            valueList: ['candidat']
                        }
                    },
                    statutCandidat: {
                        type: 'equals',
                        field: 'statutCandidat',
                        value: 'nouveau'
                    }
                }
            };
        }
    });
});
