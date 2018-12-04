var datatables = {
	//Table Customer
    table_customer : function() {
        $('#table-customer').DataTable({
            processing : true,
            serverSide : true,
            ajax : getCustomer,
            columns : [
                {data: 'rownum', name: 'rownum', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'name'},
                {data: 'type'},
                {data: 'email'},
                {data: 'phone'},
                {data: 'address'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
        })
    },

	table_customer_type : function() {
		$('#table-customer-type').DataTable({
			processing: true,
			serverSide: true,
			ajax: getCustomerType,
			columns: [
				{data: 'rownum', name: 'rownum', orderable: false, searchable: false },
				{data: 'name'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
			],
			paging: false,
			searching: false,
			lengthChange:false,
			info: false
		})
	},
}