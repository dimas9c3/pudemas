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
	},

	// Item
	destroyItem : function() {
		$('#table-item tbody').on('click', '.button-destroy', function() {
			$('.id-item').val($(this).attr('id'));
			$('.image-item').val($(this).attr('image'));
			if ($(this).attr('image') == "") {
				$('.image-preview').attr('src', path_item+'/item-template.png');
				console.log('image null');
			}else {
				$('.image-preview').attr('src', path_item+'/thumbnail/'+$(this).attr('image'));		
			}
			
			$('#delete-item').modal('show');
		})
	},
	updateItem : function() {
		$('#table-item tbody').on('click', '.button-update', function() {
			id = $(this).attr('id');
			$.ajax({
				url : getItemById,
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
				$('.id-item').val(data[0].id);
				$('.image-item').val(data[0].image);
				$('#update-nama-item').val(data[0].name);
				$('#update-beli-item').val(data[0].purchase_price);
				$('#update-jual-item').val(data[0].selling_price);

				if (data[0].image == null) {
					$('.image-preview').attr('src', path_item+'/item-template.png');
					console.log('image null');
				}else {
					$('.image-preview').attr('src', path_item+'/thumbnail/'+data[0].image);		
				}

				var option = new Option(data[0].kategori, data[0].id_kategori, true, true);
				$('#update-kategori-item').append(option).trigger('change');

				$('#update-kategori-item').trigger({
					type : 'select2:select',
					params : {
						data : data[0].id_kategori
					}
				})

				var option2 = new Option(data[0].merk, data[0].id_merk, true, true);
				$('#update-merk-item').append(option2).trigger('change');

				$('#update-merk-item').trigger({
					type : 'select2:select',
					params : {
						data : data[0].id_merk
					}
				})

				$('#update-item').modal('show');
			})
		})
	},
	// Item Category 1
	destroyItemCategory1 : function() {
		$('#table-item-category1 tbody').on('click', '.button-destroy', function() {
			$('.id-item-category1').val($(this).attr('id'));
			$('#delete-item-category1').modal('show');
		})
	}, 
	updateItemCategory1 : function() {
		$('#table-item-category1 tbody').on('click', '.button-update', function() {
			$('.id-item-category1').val($(this).attr('id'));
			$('#update-nama-item-category1').val($(this).attr('name'));
			$('#update-item-category1').modal('show');
		})
	},
	// Item Category 2
	destroyItemCategory2 : function() {
		$('#table-item-category2 tbody').on('click', '.button-destroy', function() {
			$('.id-item-category2').val($(this).attr('id'));
			$('#delete-item-category2').modal('show');
		})
	}, 
	updateItemCategory2 : function() {
		$('#table-item-category2 tbody').on('click', '.button-update', function() {
			$('.id-item-category2').val($(this).attr('id'));
			$('#update-nama-item-category2').val($(this).attr('name'));
			$('#update-item-category2').modal('show');
		})
	},

	// Supplier
	destroySupplier : function() {
		$('#table-supplier tbody').on('click', '.button-destroy', function() {
			$('.id-supplier').val($(this).attr('id'));
			$('#delete-supplier').modal('show');
		})
	},

	updateSupplier : function() {
		$('#table-supplier tbody').on('click', '.button-update', function() {
			$.ajax({
				url 	: getSupplierById,
				type 	: 'POST',
				dataType: 'JSON',
				data 	: {id:$(this).attr('id'), _token: token},
				success : function(data) {
					console.log('Ambil Data Berhasil');
				},
				error 	: function(data) {
					alert('Ambil Data Gagal');
				}
			}).then(function(data) {
				$('.id-supplier').val(data.id);
				$('#update-name').val(data.name);
				$('#update-email').val(data.email);
				$('#update-phone').val(data.phone);
				$('#update-address').val(data.address);
				$('#update-supplier').modal('show');
			});
		});
	},

}

var select2 = {
	//Customer
	selectCustomerType : function() {
		$('.select-customer-type').select2({
			placeholder: 'Pilih Jenis Customer',
			ajax: {
				dataType: 'json',
				url: selectCustomerType,
				delay: 100,
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
	},

	selectCustomer : function() {
		$('.select-customer').select2({
			placeholder: 'Pilih Customer',
			ajax: {
				dataType: 'json',
				url: selectCustomer,
				delay: 100,
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
	},

	//Item
	selectItem : function() {
		$('.select-item').select2({
			placeholder: 'Pilih Barang',
			ajax: {
				dataType: 'json',
				url: selectItem,
				delay: 100,
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
	},
	selectItemCategory1 : function() {
		$('.select-item-category1').select2({
			placeholder: 'Pilih Kategori Barang',
			ajax: {
				dataType: 'json',
				url: selectItemCategory1,
				delay: 100,
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
	},
	selectItemCategory2 : function() {
		$('.select-item-category2').select2({
			placeholder: 'Pilih Merk Barang',
			ajax: {
				dataType: 'json',
				url: selectItemCategory2,
				delay: 100,
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
	},

	//Supplier
	selectSupplier : function() {
		$('.select-supplier').select2({
			placeholder: 'Pilih Supplier',
			ajax: {
				dataType: 'json',
				url: selectSupplier,
				delay: 100,
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
	},

	// Courier
	selectCourier : function() {
		$('.select-courier').select2({
			placeholder: 'Pilih Kurir',
			ajax: {
				dataType: 'json',
				url: selectCourier,
				delay: 100,
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
	},
}

var event = {
	is_send :function() {
		$('#is_send').on('change', function() {
			option = $(this).val();

			if (option == '1') {
				html = 	'<div class="em-separator separator-dashed"></div>'+
						'<h4>Input Data Barang Yang Dikirim</h4>'+
						'<div class="em-separator separator-dashed"></div>'+
						'<div class="form-group row d-flex align-items-center mb-3 is-visible">'+
							'<label class="col-lg-4 form-control-label d-flex justify-content-lg-start">Harga Jual Barang</label>'+
							'<div class="col-lg-8">'+
								'<input type="number" name="selling_price" id="selling_price" class="form-control input-selling-price">'+
							'</div>'+
						'</div>';
				html2 = '<div class="em-separator separator-dashed"></div>'+
						'<h4>Finalisasi Data Barang Yang Dikirim</h4>'+
						'<div class="em-separator separator-dashed"></div>'+
						'<div class="form-group row d-flex align-items-center mb-5">'+
							'<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Customer</label>'+
							'<div class="col-lg-4">'+
								'<select name="customer" class="form-control select-customer" required></select>'+
							'</div>'+
							'<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Alamat Pengiriman</label>'+
							'<div class="col-lg-4">'+
								'<textarea class="form-control input-alamat" rows="5" placeholder="Type your message here ..." required></textarea>'+
								'<div class="invalid-feedback">'+
									'Please enter a custom message'+
								'</div>'+
							'</div>'+
						'</div>';

				$('#item-visible').html(html);

				$('#item-visible2').html(html2);

				$('#is_send_to_customer').val('1');

				select2.selectCustomer();

				event.selectCustomerChange();
			}else if (option == '0') {
				html = 	'';
				html2 = '';
				$('#item-visible').html(html);
				$('#item-visible2').html(html2);
				$('#is_send_to_customer').val('0');
			}
		});
	},

	selectItemChange : function() {
		$('.select-item').on('change', function() {
			id 		= $(this).val();
			$.ajax({
				url 		: getItemById,
				type 		: 'POST',
				dataType 	: 'JSON',
				data 		: {id:id, _token:token},
				success 	: function(data) {
					console.log('Data Berhasil Diambil');
				},
				error 		: function(data) {
					alert('Data Gagal Diambil');
				}
			}).then(function(data) {
				$('.input-purchase-price').val(data[0].purchase_price);
				$('.input-selling-price').val(data[0].selling_price);
				$('.input-qty').val('1');
			});
		});
		
	},

	selectCustomerChange : function() {
		$('.select-customer').on('change', function() {
			id 		= $(this).val();
			$.ajax({
				url 		: getCustomerById,
				type 		: 'POST',
				dataType 	: 'JSON',
				data 		: {id:id, _token:token},
				success 	: function(data) {
					console.log('Data Berhasil Diambil');
				},
				error 		: function(data) {
					alert('Data Gagal Diambil');
				}
			}).then(function(data) {
				$('.input-alamat').val(data[0].address);
			});
		});
		
	},
}
