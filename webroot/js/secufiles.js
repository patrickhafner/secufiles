var Secufiles = {


    Storage: {

        add: function (record) {

            var storage = Secufiles.Storage.get();
            storage.push(record);
            $.jStorage.set('secufiles', storage);

            storage = null;

        },


        set: function (records) {
            $.jStorage.set('secufiles', records);
        },

        get: function () {

            if (!$.jStorage.get('secufiles')) {
                $.jStorage.set('secufiles', []);
            }

            return $.jStorage.get('secufiles');

        },

        getHashesAsString: function () {

            var hashes = '';

            $.each(Secufiles.Storage.get(), function (key, Secufile) {

                hashes = hashes + Secufile.hash + ';'

            });

            return hashes;
        },


        getDeleteCodeByHash: function (hash) {
            var storage = this.get();
            var obj = storage.filter(function (Secufile) {
                return Secufile.hash == hash;
            });


            if (obj.length > 0) {
                return obj[0]['delete_code'];
            } else {
                return;
            }

        }

    },


    App: {

        showList: function () {
            var table = $('tbody#secufiles-js-client-table');

            var validatedRecords = [];


            if (Secufiles.Storage.getHashesAsString() == '') {
                return;
            }

            $.ajax({
                url: Secufiles.baseURL + 'ajax/' + Secufiles.Storage.getHashesAsString(),
                type: 'POST',
                success: function (data) {

                    $.each(data, function (key, Secufile) {

                        var hash = Secufile.Secufile.hash;

                        if (Secufile.Secufile.remaining_views == 0) {
                            return;
                        }

                        var deleteLink = 'delete/' + hash + '/' + Secufiles.Storage.getDeleteCodeByHash(hash);


                        var record = Secufiles.Storage.get().filter(function (Secufile) {
                            return Secufile.hash == hash;
                        });
                        validatedRecords.push(record[0]);

                        var row = ''
                        if (Secufile.Secufile.containsPhoto) {
                            row = '<td><img class="table-icon" src="' + Secufiles.baseURL + 'img/photo.png">' + '</td>';
                        } else {
                            row = '<td></td>';
                        }
                        /**/

                        table.append(
                            '<tr id="' + hash + '">' +
                            '<td><a href="' + Secufiles.baseURL + '/v/' + hash + '">' + hash + '</a></td>' +
                            '<td>' + Secufile.Secufile.created_at + '</td>' +
                            '<td>' + Secufile.Secufile.remaining_views + '</td>' +
                            row +
                            '<td><a class="delete-record" href="' + Secufiles.baseURL + deleteLink + '"><img class="table-icon" src="' + Secufiles.baseURL + 'img/remove.png" /></a></td>' +
                            '</tr>'
                        );

                    });

                    // update local storage
                    Secufiles.Storage.set(validatedRecords);

                    $('a.delete-record').click(function (e) {
                        if (confirm('Delete?')) {
                            return true;
                        } else {
                            e.preventDefault();
                            return false;
                        }
                    });

                }
            });


        }

    }

};