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

    // Table Item
    table_item : function() {
        $('#table-item').DataTable({
            processing : true,
            serverSide : true,
            ajax : getItem,
            columns : [
            {data: 'rownum', name: 'rownum', orderable: false, searchable: false},
            {data: 'foto', name: 'foto', orderable: false, searchable: false},
            {data: 'kategori'},
            {data: 'merk'},
            {data: 'name'},
            {data: 'purchase_price'},
            {data: 'selling_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },
    
    table_item_category1 : function() {
        $('#table-item-category1').DataTable({
            processing: true,
            serverSide: true,
            ajax: getItemCategory1,
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
    table_item_category2 : function() {
        $('#table-item-category2').DataTable({
            processing: true,
            serverSide: true,
            ajax: getItemCategory2,
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

    // Table Supplier
    table_supplier : function() {
        $('#table-supplier').DataTable({
            processing : true,
            serverSide : true,
            ajax : getSupplier,
            columns : [
            {data: 'rownum', name: 'rownum', orderable: false, searchable: false},
            {data: 'name'},
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

     // Table Pickup finish
    table_pickup : function() {
        $('#table-pickup-active').DataTable({
            processing : true,
            serverSide : true,
            ajax : getPickup,
            columns : [
            {data: 'id_pickup'},
            {data: 'date'},
            {data: 'status'},
            {data: 'courier_name'},
            {data: 'type'},
            {data: 'is_send_to_customer'},
            {data: 'item_name'},
            {data: 'supplier_name'},
            {data: 'qty'},
            {data: 'purchase_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },

    // Table Pickup Active
    table_pickup_active : function() {
        $('#table-pickup-active').DataTable({
            processing : true,
            serverSide : true,
            ajax : getPickupActive,
            columns : [
            {data: 'id_pickup'},
            {data: 'status'},
            {data: 'courier_name'},
            {data: 'type'},
            {data: 'is_send_to_customer'},
            {data: 'item_name'},
            {data: 'supplier_name'},
            {data: 'qty'},
            {data: 'purchase_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },

     // Table Pickup cancel
    table_pickup_cancel : function() {
        $('#table-pickup-cancel').DataTable({
            processing : true,
            serverSide : true,
            ajax : getPickupCancel,
            columns : [
            {data: 'id_pickup'},
            {data: 'date'},
            {data: 'status'},
            {data: 'courier_name'},
            {data: 'type'},
            {data: 'is_send_to_customer'},
            {data: 'item_name'},
            {data: 'supplier_name'},
            {data: 'qty'},
            {data: 'purchase_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },

    table_pickup_active_courier : function() {
        $('#table-pickup-active').DataTable({
            processing : true,
            serverSide : true,
            ajax : getPickupActiveCourier,
            columns : [
            {data: 'id_pickup'},
            {data: 'status'},
            {data: 'courier_name'},
            {data: 'type'},
            {data: 'is_send_to_customer'},
            {data: 'item_name'},
            {data: 'supplier_name'},
            {data: 'qty'},
            {data: 'purchase_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },

    /* DELIVERY SECTION */
    // Table Delivery Active
    table_delivery : function() {
        $('#table-delivery').DataTable({
            processing : true,
            serverSide : true,
            ajax : getDelivery,
            columns : [
            {data: 'id_delivery'},
            {data: 'date'},
            {data: 'status'},
            {data: 'customer_name'},
            {data: 'courier_name'},
            {data: 'is_pickup_first'},
            {data: 'send_cost'},
            {data: 'item_name'},
            {data: 'qty'},
            {data: 'selling_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },

    // Table Delivery Active
    table_delivery_active : function() {
        $('#table-delivery-active').DataTable({
            processing : true,
            serverSide : true,
            ajax : getDeliveryActive,
            columns : [
            {data: 'id_delivery'},
            {data: 'status'},
            {data: 'customer_name'},
            {data: 'courier_name'},
            {data: 'is_pickup_first'},
            {data: 'send_cost'},
            {data: 'item_name'},
            {data: 'qty'},
            {data: 'selling_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },

     // Table Delivery Active Courier
    table_delivery_active_courier : function() {
        $('#table-delivery-active').DataTable({
            processing : true,
            serverSide : true,
            ajax : getDeliveryActiveCourier,
            columns : [
            {data: 'id_delivery'},
            {data: 'status'},
            {data: 'customer_name'},
            {data: 'courier_name'},
            {data: 'is_pickup_first'},
            {data: 'send_cost'},
            {data: 'item_name'},
            {data: 'qty'},
            {data: 'selling_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },

     // Table Delivery Cancel
    table_delivery_cancel : function() {
        $('#table-delivery').DataTable({
            processing : true,
            serverSide : true,
            ajax : getDeliveryCancel,
            columns : [
            {data: 'id_delivery'},
            {data: 'date'},
            {data: 'status'},
            {data: 'customer_name'},
            {data: 'courier_name'},
            {data: 'is_pickup_first'},
            {data: 'send_cost'},
            {data: 'item_name'},
            {data: 'qty'},
            {data: 'selling_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },

    // Table Other Expenses
    table_other_expenses : function() {
        $('#table-expenses').DataTable({
            processing : true,
            serverSide : true,
            ajax : getOtherExpenses,
            columns : [
            {data: 'rownum', name: 'rownum', orderable: false, searchable: false},
            {data: 'date'},
            {data: 'created_by'},
            {data: 'subject'},
            {data: 'amount'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            paging : true,
            searching : true,
            lengthChange : true,
            info : true,
            aaSorting : [],
        })
    },
}
