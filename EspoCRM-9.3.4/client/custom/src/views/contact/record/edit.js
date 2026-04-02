define('custom:views/contact/record/edit', ['views/record/edit'], function (Dep) {
    return class extends Dep {
        setup() {
            super.setup();

            if (!this.model || !this.model.isNew()) {
                return;
            }

            const currentUser = this.getUser();
            const currentUserId = currentUser.id;
            const currentUserName = currentUser.get('name');

            const assignedUserId = this.model.get('assignedUserId');

            if (!assignedUserId || assignedUserId !== currentUserId) {
                this.model.set({
                    assignedUserId: currentUserId,
                    assignedUserName: currentUserName,
                });
            }

            // Keep system links empty on create; Espo fills them itself on save.
            this.model.unset('createdById');
            this.model.unset('createdByName');
            this.model.unset('modifiedById');
            this.model.unset('modifiedByName');
        }
    };
});
