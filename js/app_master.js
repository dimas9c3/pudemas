var showModal = {
	// Customer
	destroyCustomer : function() {
		$('#table-customer tbody').on('click', '.button-destroy', function() {
			$('.id-customer').val($(this).attr('id'));
			$('#delete-customer').modal('show');
		})
	},
	updateCustomer : function() {
		$('#table-customer tbody').on('click', '.button-update', function() {
			id = $(this).attr('id');
			$.ajax({
				url : getCustomerById,
				type : 'POST',
				data : {_token:token, id: id},
				dataType : 'JSON',
				success : function(data) {
					console.log('Ambil Data Berhasil');
				},
				error : function(data) {
					alert('Ambil Data Gagal');
				}
			}).then(function(data) {
				$('#edit-customer-id').val(data[0].id);
				$('#edit-customer-name').val(data[0].name);
				$('#edit-customer-email').val(data[0].email);
				$('#edit-customer-phone').val(data[0].phone);
				$('#edit-customer-address').val(data[0].address);

				var option = new Option(data[0].type, data[0].type_id, true, true);
				$('#edit-customer-type').append(option).trigger('change');

				$('#edit-customer-type').trigger({
					type : 'select2:select',
					params : {
						data : data[0].type_id
					}
				})
				$('#update-customer').modal('show');
			})
		})
	},
	// Customer Type
	destroyCustomerType : function() {
		$('#table-customer-type tbody').on('click', '.button-destroy', function() {
			$('#customer-type').modal('hide');
			$('.id-customer-type').val($(this).attr('id'));
			$('#delete-customer-type').modal('show');
		})
	},
	updateCustomerType : function() {
		$('#table-customer-type tbody').on('click', '.button-update', function() {
			$('#customer-type').modal('hide');
			$('.id-customer-type').val($(this).attr('id'));
			$('#update-nama-customer-type').val($(this).attr('name'));
			$('#update-customer-type').modal('show')
		})
	} 
}

var select2 = {
	selectCustomerType : function() {
		$('.select-customer-type').select2({
			placeholder: 'Pilih Jenis Customer',
            ajax: {
                dataType: 'json',
                url: selectCustomerType,
                delay: 250,
                data: function (params) {
			    return {
			    	q: params.term, // search term
			        page: params.page
			      };
			    },
                processResults: function (data, page) {
                  return {
                    results: data
                  };
                },
            },
            formatSelection: function(item) {
            	return item.id;
            },
		});
	}
}