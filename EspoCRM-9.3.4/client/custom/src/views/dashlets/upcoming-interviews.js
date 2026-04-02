define('custom:views/dashlets/upcoming-interviews', ['views/dashlets/abstract/record-list'], function (Dep) {
    return Dep.extend({
        name: 'UpcomingInterviews',
        scope: 'Candidature',

        getSearchData: function () {
            const today = new Date().toISOString().slice(0, 10);

            return {
                advanced: [
                    {
                        attribute: 'dateEntretien',
                        type: 'greaterThanOrEquals',
                        value: today
                    },
                    {
                        attribute: 'statutCandidature',
                        type: 'notIn',
                        value: ['acceptee', 'refuseeEntreprise', 'refuseeCandidat', 'abandonnee', 'transformeeContrat']
                    }
                ]
            };
        }
    });
});
