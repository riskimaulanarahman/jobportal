var modname = 'momrequest'; // api
var modelclass = 'Mom'; // module name
var popupmode;
var d = new Date();

function moveEditColumnToLeft(dataGrid) {
    dataGrid.columnOption("command:edit", { 
        visibleIndex: -1,
        width: 80 
    });
}


var dataGrid = $("#gridContainer").dxTreeList({    
    dataSource: store(modname),
    keyExpr: 'id',
    parentIdExpr: 'parentID',
    allowColumnReordering: true,
    allowColumnResizing: true,
    // columnsAutoWidth: true,
    columnHidingEnabled: true,
    rowAlternationEnabled: false,
    wordWrapEnabled: true,
    // focusedRowEnabled: true,
    autoExpandAll: true,
    showBorders: true,
    filterRow: { visible: true },
    filterPanel: { visible: true },
    headerFilter: { visible: true },
    // selection: {
    //     mode: 'single',
    //     recursive: true,
    // },
    searchPanel: {
        visible: true,
        width: 240,
        placeholder: 'Search...',
    },
    editing: {
        useIcons:true,
        mode: "popup",
        allowAdding: false,
        allowUpdating: false,
        allowDeleting: true,
    },
    scrolling: {
        mode: "virtual"
    },
    pager: {
        visible: false,
        showInfo: true,
    },
    columns: [

        {
            dataField: 'subjectMeeting',
            width: 220,
        },
        {
            caption: 'Action',
            width: 140,
            cellTemplate: function(container, options) {

                var isMine = options.data.isMine;
                var isPendingOnMe = options.data.isPendingOnMe;
                var reqid = options.data.id;
                var reqstatus = options.data.requestStatus;
                var mode = (reqstatus == 0 || reqstatus == 2 && (isMine == 1)) ? 'edit' : (reqstatus == 1 && ((isMine == 0 && isPendingOnMe == 1) || (isMine == 1 && isPendingOnMe == 1)) ? 'approval' : 'view') ;
                var arrColor = [
                    "btn-secondary",
                    (mode == 'approval' && reqstatus == 1) ? "btn-danger" : "btn-primary",
                    "btn-warning",
                    "btn-success",
                    "btn-danger",
                ];

                var viewIcon = (mode == 'approval' && reqstatus == 1) ? "fa-check" : "fa-search";
    
                $('<button class="btn '+arrColor[reqstatus]+'" id="btnreqid'+reqid+'"><i class="fa '+viewIcon+'"></i></button>').on('dxclick', function(evt) {
                    evt.stopPropagation();
                
                            popup.option({
                                contentTemplate: () => popupContentTemplate(reqid,mode,options),
                            });
                            popup.show();

                }).appendTo(container);
                if((reqstatus == 1 || reqstatus == 2) && ((isMine == 1 && (isPendingOnMe == 0 || isPendingOnMe == null)))) {
                    $('<button class="btn btn-danger" id="btnreqid'+reqid+'" style="margin-left: 3px;">Cancel</button>').on('dxclick', function(evt) {
                        evt.stopPropagation();
                            
                        var result = confirm('Are you sure you want to cancel this submission ?');

                        if (result) {
                            sendRequest(apiurl + "/submissionrequest/"+reqid+"/"+modelclass, "POST", {
                                requestStatus:0,
                                action:'submission',
                                approvalAction: 0
                            }).then(function(response){
                                if(response.status != 'error') {
                                    dataGrid.refresh();
                                }
                            });
                        } else {
                            alert('Cancelled.');
                        }
    
                    }).appendTo(container); 
                }
                if(reqstatus == 3) {
                    $('<button class="btn btn-info" id="btnpdfid'+reqid+' m-l-3" style="margin-left: 3px;"><i class="fa fa-download"></i></button>').on('dxclick', function(evt) {
                        evt.stopPropagation();
                            
                        var result = confirm('Attention ! please wait until the generate process is complete.');

                        if (result) {
                            window.open('./gen-pdf/mom/'+reqid, '_blank')
                        } else {
                            alert('Cancelled.');
                        }
    
                    }).appendTo(container); 
                }
            
            }
        },
        {
            caption: "Code",
            dataField: 'code',
        },
        { 
			dataField: "user.fullname",
            caption: 'Creator Name',
            width: 180
        },
        {
            dataField: 'chairman',
        },
        {
            caption: "Meeting Date",
            dataField: "date",
            dataType: "date",
            format: "dd-MM-yyyy",
        },
        {
            dataField: 'venue',
        },
        {
            caption: "is Zoom ?",
			dataField: "isZoom",
            dataType: "boolean"
        },
        {
            caption: "is Confidential ?",
			dataField: "isConfidential",
            dataType: "boolean"
        },
        {
            dataField: 'requestStatus',
            encodeHtml: false,
            allowFiltering: false,
            allowHeaderFiltering: true,
            customizeText: function (e) {
                var arrText = [
                    "<span class='btn btn-secondary btn-xs btn-status'>Draft</span>",
                    "<span class='btn btn-primary btn-xs btn-status'>Waiting Approval</span>",
                    "<span class='btn btn-warning btn-xs btn-status'>Rework</span>",
                    "<span class='btn btn-success btn-xs btn-status'>Approved</span>",
                    "<span class='btn btn-danger btn-xs btn-status'>Rejected</span>",
                ];
                return arrText[e.value];
            },
            width: 180
        },
      
    ],
    export: {
        enabled: true,
        fileName: modname,
        excelFilterEnabled: true,
        allowExportSelectedData: true
    },
    onContentReady: function(e){
        moveEditColumnToLeft(e.component);
        runpopup();
        runpopupdetails();
        runpopupactions();
    },
    onCellPrepared: function (e) {
        if (e.rowType == "data") {
            if(e.data.isParent === 1) {
                e.cellElement.css('background','rgba(128, 128, 0,0.1)')
            }
        }
    },
    onToolbarPreparing: function(e) {
        dataGrid = e.component;

        e.toolbarOptions.items.unshift({						
            location: "after",
            widget: "dxButton",
            options: {
                hint: "Refresh Data",
                icon: "refresh",
                onClick: function() {
                    dataGrid.refresh();
                }
            }
        })
    },
    onDataErrorOccurred: function(e) {
        // Menampilkan pesan kesalahan
        console.log("Terjadi kesalahan saat memuat data (0):", e.error.message);

        // Memuat ulang Page
        location.reload();
    }
}).dxTreeList("instance");

$('#btnadd').on('click',function(){
    sendRequest(apiurl + "/"+modname, "POST", {requestStatus:0}).then(function(response){
        const reqid = response.data.id;
        const mode = 'add';
        const options = {"data": {"isMine": 1}};
        popup.option({
            contentTemplate: () => popupContentTemplate(reqid,mode,options),
        });
        popup.show();
    });
})

const accordionItems = [
    {
        ID: 1,
        Title: '<i class="far fa-newspaper"> Form Data </i>',
        visible: true
    },
    {
        ID: 6,
        Title: '<i class="fas fa-list-ul"> Participant </i>',
        visible: true
    },
    {
        ID: 7,
        Title: '<i class="fas fa-newspaper"> Task </i>',
        visible: true
    },
    {
        ID: 2,
        Title: '<i class="fas fa-file"> Supporting Document </i>',
        visible: true
    },
    {
        ID: 3,
        Title: '<i class="fas fa-list-ul"> Approver List </i>',
        visible: true
    },
    {
        ID: 4,
        Title: '<i class="fas fa-history"> History </i>',
        visible: true
    },
];

const accordionItemsDetails = [
    {
        ID: 1,
        Title: '<i class="far fa-newspaper"> Data </i>',
        visible: true
    },
];

const updateVisibleById = (itemId, visible) => {
    accordionItems.forEach(item => {
      if (item.ID === itemId) {
        item.visible = visible;
      }
    });
  };

const popupContentTemplate = function (reqid,mode,options) {

    isMine = options.data.isMine;
    var isPendingOnMe = options.data.isPendingOnMe;
    isChairman = options.data.isChairman;

    popupid = reqid;

    const scrollView = $('<div />');

    if ((isMine == 1 || isPendingOnMe == 1) && (mode == 'add' || mode == 'edit' || mode == 'approval')) {
        if((isPendingOnMe == 1) && (mode == 'approval')) {
            var approvalOptions = 
                '<div class="row">' +
                    '<div class="col-md-6">' +
                    '<label for="remarks">Approval Action :</label>' +
                    '<div class="form-check">'+
                        '<input class="form-check-input" type="radio" name="approvalaction" id="rappraction1" value="3">'+
                        '<label class="form-check-label" for="rappraction1">'+
                        'Approved'+
                        '</label>'+
                    '</div>'+
                    '<div class="form-check">'+
                        '<input class="form-check-input" type="radio" name="approvalaction" id="rappraction2" value="2">'+
                        '<label class="form-check-label" for="rappraction2">'+
                        'Reworked'+
                        '</label>'+
                    '</div>'+
                    '<div class="form-check mb-3">'+
                        '<input class="form-check-input" type="radio" name="approvalaction" id="rappraction3" value="4">'+
                        '<label class="form-check-label" for="rappraction3">'+
                        'Rejected'+
                        '</label>'+
                    '</div>'+
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<div class="form-group">' +
                        '<label for="remarks">Remarks :</label>' +
                        '<textarea class="form-control" id="remarks" rows="3"></textarea>' +
                    '</div>' +
                    '</div>' +
                '</div><hr>';
          } else {
            var approvalOptions = '';
          }
          
          scrollView.append('<div class="row">' +
            '<div class="col-lg-12">' +
              '<div class="card">' +
                '<div class="card-header">' +
                  '<h5 class="card-title">Form Action</h5>' +
                '</div>' +
                '<div class="card-body" style="border-bottom-color: darkseagreen !important;border-left-color: darkseagreen;">' +
                  approvalOptions +
                  '<button id="btn-submit" type="button" onClick="btnreqsubmit('+reqid+',\''+mode+'\')" class="btn btn-success waves-effect btn-label waves-light m-1"><i class="bx bx-check-double label-icon"></i> Release</button>'+
                '</div>' +
              '</div>' +
            '</div>' +
          '</div>');
    }

    updateVisibleById(5, true);

    scrollView.append("<hr>"),

    scrollView.append(

        $("<div>").dxAccordion({
            dataSource: accordionItems,
            animationDuration: 600,
            selectedItems: [accordionItems[0],accordionItems[1],accordionItems[2],accordionItems[3],accordionItems[4],accordionItems[5],accordionItems[6],accordionItems[7]],
            collapsible: true,
            multiple: true,
            itemTitleTemplate: function (data) {
                if(data.ID == 5) {
                    color = 'red';
                } else {
                    color = 'black';
                }
                return '<small style="margin-bottom:10px !important; color:'+color+'">'+data.Title+'</small>'
            },
            itemTemplate: function (data) {
                var container = $("<div>");
                if(data.ID == 1) {
                    if (mode == 'add' || mode == 'edit'){
                        $("<span style='color:red;font-size:11pt'>").html('Silahkan lengkapi <b><i style="color:black;font-weight:bold" class="far fa-newspaper"> Form Data </i></b> dan tekan tombol <b>Simpan</b> (<i style="color:black;font-weight:bold" class="fas fa-save"></i>) yang ada di pojok kanan atas tabel serta lampirkan <i style="color:black;font-weight:bold" class="fas fa-file"> Supporting Document </i> sebelum klik tombol <span style="color:black;font-weight:bold"><i class="bx bx-check-double label-icon"></i> Submit Submission</span>').appendTo(container);
                    }
                    var formData = $("<div id='formdata'>").dxDataGrid({    
                        dataSource: storedetail(modname,reqid),
                        allowColumnReordering: true,
                        allowColumnResizing: true,
                        columnsAutoWidth: true,
                        rowAlternationEnabled: true,
                        wordWrapEnabled: true,
                        showBorders: true,
                        showColumnLines:true,
                        filterRow: { visible: false },
                        filterPanel: { visible: false },
                        headerFilter: { visible: false },
                        searchPanel: {
                            visible: false,
                            width: 240,
                            placeholder: 'Search...',
                        },
                        sorting: {
                            mode: "none" // or "multiple" | "none"
                        },
                        editing: {
                            useIcons:true,
                            mode: "batch",
                            allowAdding: false,
                            allowUpdating: ((isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                            allowDeleting: false,
                        },
                        scrolling: {
                            mode: "virtual"
                        },
                        columns: [
                            {
                                caption: 'Code',
                                dataField: 'code',
                                allowFiltering: false,
                                allowHeaderFiltering: false,
                                editorOptions: { 
                                    readOnly: true
                                }
                            },
                            {
                                dataField: 'subjectMeeting',
                                dataType: 'string',
                                validationRules: [{ type: "required" }]
                            },
                            {
                                caption: "Meeting Date",
                                dataField: "date",
                                dataType: "date",
                                format: "dd-MM-yyyy", 
                                validationRules: [{ type: "required" }]
                            },
                            {
                                dataField: 'chairman',
                                dataType: 'string',
                                validationRules: [{ type: "required" }]
                            },
                            {
                                dataField: 'venue',
                                dataType: 'string',
                                validationRules: [{ type: "required" }]
                            },
                            {
                                dataField: 'isZoom',
                                dataType: 'boolean',
                            },
                            {
                                caption: "is Confidential ?",
                                dataField: "isConfidential",
                                dataType: "boolean"
                            },
                            {
                                dataField: "created_at",
                                dataType: "date",
                                format: "dd-MM-yyyy", 
                                editorOptions: { 
                                    readOnly: true
                                }
                            },
                        ],
                        export: {
                            enabled: false,
                            fileName: modname,
                            excelFilterEnabled: true,
                            allowExportSelectedData: true
                        },
                        onInitialized: function(e) {
                            dataGrid1 = e.component;
                        },
                        onContentReady: function(e){
                            moveEditColumnToLeft(e.component);
                        },
                        onInitNewRow : function(e) {
                        },
                        onToolbarPreparing: function(e) {
                            e.toolbarOptions.items.unshift({						
                                location: "after",
                                widget: "dxButton",
                                options: {
                                    hint: "Refresh Data",
                                    icon: "refresh",
                                    onClick: function() {
                                        dataGrid1.refresh();
                                    }
                                }
                            });
                        },
                        onEditorPreparing: function (e) {
                        },
                        onCellPrepared: function (e) {
                            if (e.column.index == 0 && e.rowType == "data") {
                                if(e.data.code === null) {
                                    $("#formdata").dxDataGrid('columnOption','code', 'visible', false);
                                } else {
                                    $("#formdata").dxDataGrid('columnOption','code', 'visible', true);
                                }
                            }
                            if ( e.rowType == "data" && (e.column.index>0 && e.column.index<6)) {
                                if (e.value === "" || e.value === null || e.value === undefined || /^\s*$/.test(e.value)) {
                                    e.cellElement.css({
                                        "backgroundColor": "#ffe6e6",
                                        "border": "0.5px solid #f56e6e"
                                    })
                                }
                            }
                        },
                        onDataErrorOccurred: function(e) {
                            // Menampilkan pesan kesalahan
                            console.log("Terjadi kesalahan saat memuat data (1):", e.error.message);
                    
                            // Memuat ulang DataGrid
                            dataGrid1.refresh();
                        }
                    }).appendTo(container)
                    return container
                } 
                else if(data.ID == 7) {
                    return formData = $("<div id='formdetail'>").dxDataGrid({    
                        dataSource: storewithmodule('categorysubmission',modelclass,reqid),
                        allowColumnReordering: true,
                        allowColumnResizing: true,
                        columnsAutoWidth: true,
                        rowAlternationEnabled: true,
                        wordWrapEnabled: true,
                        showBorders: true,
                        showColumnLines:true,
                        filterRow: { visible: false },
                        filterPanel: { visible: false },
                        headerFilter: { visible: false },
                        searchPanel: {
                            visible: true,
                            width: 240,
                            placeholder: 'Search...',
                        },
                        sorting: {
                            mode: "none" // or "multiple" | "none"
                        },
                        editing: {
                            useIcons:true,
                            mode: "row",
                            allowAdding: ((isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                            allowUpdating: ((isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                            allowDeleting: ((isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                        },
                        scrolling: {
                            mode: "virtual"
                        },
                        columns: [
                            {
                                dataField: 'category',
                                dataType: 'string',
                                validationRules: [{ type: "required" }]
                            },
                            {
                                caption: 'Task Status',
                                dataField: 'status_summary',
                                editorOptions: { 
                                    readOnly: true
                                }
                            },
                            {
                                caption: 'Handled By',
                                dataField: 'FullName',
                                editorOptions: { 
                                    readOnly: true
                                }
                            },
                            {
                                caption: 'Action',
                                width: 140,
                                cellTemplate: function(container, options) {                    
                                    $('<button class="btn btn-primary"><i class="fa fa-search"></i></button>').on('dxclick', function(evt) {
                                        evt.stopPropagation();
                                            popupdetails.option({
                                                contentTemplate: () => popupContentTemplateDetails(reqid,mode,options),
                                            });
                                            popupdetails.show();
                                    }).appendTo(container);
                                },
                                visible: true
                            },
                        ],
                        export: {
                            enabled: false,
                            fileName: modname,
                            excelFilterEnabled: true,
                            allowExportSelectedData: true
                        },
                        onInitialized: function(e) {
                            dataGriddetail = e.component;
                        },
                        onContentReady: function(e){
                            moveEditColumnToLeft(e.component);
                                // e.component.columnOption('Action', 'visible', true);
                        },
                        onToolbarPreparing: function(e) {
                            e.toolbarOptions.items.unshift({						
                                location: "after",
                                widget: "dxButton",
                                options: {
                                    hint: "Refresh Data",
                                    icon: "refresh",
                                    onClick: function() {
                                        dataGriddetail.refresh();
                                    }
                                }
                            });
                        },
                        onEditorPrepared: function (e) {
                            e.editorElement.on('keydown', function(event) {
                                if (event.keyCode === 27) { // 27 is the keycode for the Escape key
                                    setTimeout(function() {
                                        e.component.columnOption('Action', 'visible', true);
                                    }, 0);
                                }
                            });
                        },
                        onCellPrepared: function (e) {
                        },
                        onEditingStart: function(e) {
                            setTimeout(function() {
                                e.component.columnOption('Action', 'visible', false);
                            }, 0);
                        },
                        onEditCanceled: function(e) {
                            setTimeout(function() {
                                e.component.columnOption('Action', 'visible', true);
                            }, 0);
                        },
                        onInitNewRow: function(e) {
                            setTimeout(function() {
                                e.component.columnOption('Action', 'visible', false);
                            }, 0);
                        },
                        onSaved: function(e) {
                            setTimeout(function() {
                                e.component.columnOption('Action', 'visible', true);
                            }, 0);
                        },
                        onDataErrorOccurred: function(e) {
                            // Menampilkan pesan kesalahan
                            console.log("Terjadi kesalahan saat memuat data (7):", e.error.message);
                    
                            // Memuat ulang DataGrid
                            dataGriddetail.refresh();
                        }
                    })
                } 
                else if(data.ID == 2) {
                    var supporting = $("<div id='formattachment'>").dxDataGrid({    
                        dataSource: storewithmodule('attachmentrequest',modelclass,reqid),
                        allowColumnReordering: true,
                        allowColumnResizing: true,
                        columnsAutoWidth: true,
                        rowAlternationEnabled: true,
                        wordWrapEnabled: true,
                        showBorders: true,
                        filterRow: { visible: false },
                        filterPanel: { visible: false },
                        headerFilter: { visible: false },
                        searchPanel: {
                            visible: true,
                            width: 240,
                            placeholder: 'Search...',
                        },
                        editing: {
                            useIcons:true,
                            mode: "popup",
                            allowAdding: ((isMine == 1 && mode == 'view') ? true : (isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                            allowUpdating: ((isMine == 1 && mode == 'view') ? true : (isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                            allowDeleting: ((isMine == 1 && mode == 'view') ? true : (isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                        },
                        paging: { enabled: true, pageSize: 10 },
                        columns: [
                            { 
                                caption: 'File',
                                dataField: "path",
                                allowFiltering: false,
                                allowSorting: false,
                                cellTemplate: cellTemplate,
                                editCellTemplate: editCellTemplate,
                                validationRules: [{ type: "required" }]
                            },
                            {
                                dataField: "remarks"
                            },
                        ],
                        export: {
                            enabled: false,
                            fileName: modname,
                            excelFilterEnabled: true,
                            allowExportSelectedData: true
                        },
                        onInitialized: function(e) {
                            dataGridAttachment = e.component;
                        },
                        onContentReady: function(e){
                            moveEditColumnToLeft(e.component);
                        },
                        onInitNewRow : function(e) {
                        },
                        onToolbarPreparing: function(e) {
                            e.toolbarOptions.items.unshift({						
                                location: "after",
                                widget: "dxButton",
                                options: {
                                    hint: "Refresh Data",
                                    icon: "refresh",
                                    onClick: function() {
                                        dataGridAttachment.refresh();
                                    }
                                }
                            })
                        },
                        onDataErrorOccurred: function(e) {
                            // Menampilkan pesan kesalahan
                            console.log("Terjadi kesalahan saat memuat data (2):", e.error.message);
                    
                            // Memuat ulang DataGrid
                            dataGridAttachment.refresh();
                        }
                    })

                    return supporting;
                }
                else if(data.ID == 3) {
                    return $("<div id='formapproverlist'>").dxDataGrid({    
                        dataSource: storewithmodule('approverlistrequest',modelclass,reqid),
                        allowColumnReordering: true,
                        allowColumnResizing: true,
                        columnsAutoWidth: true,
                        rowAlternationEnabled: true,
                        wordWrapEnabled: true,
                        showBorders: true,
                        filterRow: { visible: false },
                        filterPanel: { visible: false },
                        headerFilter: { visible: false },
                        searchPanel: {
                            visible: true,
                            width: 240,
                            placeholder: 'Search...',
                        },
                        editing: {
                            useIcons:true,
                            mode: "cell",
                            allowAdding: (admin == 1) ? true : false,
                            allowUpdating: (admin == 1) ? true : false,
                            allowDeleting: (admin == 1) ? true : false,
                        },
                        scrolling: {
                            mode: "virtual"
                        },
                        columns: [
                            {
                                caption: "Fullname",
                                dataField: "approver_id",
                                lookup: {
                                    dataSource: listOption('/list-approver/'+modelclass,'id','fullname'),  
                                    valueExpr: 'id',
                                    displayExpr: 'fullname',
                                },
                                validationRules: [
                                    { 
                                        type: "required" 
                                    }
                                ]
                            },
                            {
                                dataField: "ApprovalType",
                                editorOptions: { 
                                    readOnly: true
                                }
                            },
                            {
                                dataField: "approvalDate",
                                dataType: "datetime",
                                format: "dd-MM-yyyy hh:mm:ss",
                            },
                            {
                                caption: "Approval Status",
                                dataField: "approvalAction",
                                encodeHtml: false,
                                allowFiltering: false,
                                allowHeaderFiltering: true,
                                customizeText: function (e) {
                                    var arrText = [
                                        "<span class='btn btn-secondary btn-xs btn-status'>Draft</span>",
                                        "<span class='btn btn-primary btn-xs btn-status'>Waiting Approval</span>",
                                        "<span class='btn btn-warning btn-xs btn-status'>Rework</span>",
                                        "<span class='btn btn-success btn-xs btn-status'>Approved</span>",
                                        "<span class='btn btn-danger btn-xs btn-status'>Rejected</span>",
                                    ];
                                    return arrText[e.value];
                                }
                            },
                        ],
                        export: {
                            enabled: false,
                            fileName: modname,
                            excelFilterEnabled: true,
                            allowExportSelectedData: true
                        },
                        onInitialized: function(e) {
                            dataGridApproverList = e.component;
                        },
                        onContentReady: function(e){
                            moveEditColumnToLeft(e.component);
                        },
                        onInitNewRow : function(e) {
                        },
                        onEditorPreparing: function (e) {
                            if (e.dataField == "approver_id" && e.parentType == "dataRow") {
                                e.editorName = "dxDropDownBox";                
                                e.editorOptions.dropDownOptions = {                
                                    height: 500,
                                    width: 600
                                };
                                e.editorOptions.contentTemplate = function (args, container) {
                    
                                    var value = args.component.option("value"),
                                        $dataGrid = $("<div>").dxDataGrid({
                                            width: '100%',
                                            dataSource: args.component.option("dataSource"),
                                            keyExpr: "id",
                                            columns: ["fullname","ApprovalType"],
                                            hoverStateEnabled: true,
                                            paging: { enabled: true, pageSize: 10 },
                                            filterRow: { visible: true },
                                            height: '90%',
                                            showRowLines: true,
                                            showBorders: true,
                                            selection: { mode: "single" },
                                            selectedRowKeys: [value],
                                            focusedRowEnabled: true,
                                            focusedRowKey: args.component.option("value"),
                                            searchPanel: {
                                                visible: true,
                                                width: 265,
                                                placeholder: "Search..."
                                            },
                                            onSelectionChanged: function (selectedItems) {
                                                const keys = selectedItems.selectedRowKeys;
                                                const hasSelection = keys.length;
                                                args.component.option('value', hasSelection ? keys[0] : null);
                                                if(hasSelection !== 0) {
                                                    args.component.close();
                                                }
                                            }
                                        });
                    
                                    var dataGrid = $dataGrid.dxDataGrid("instance");
                    
                                    args.component.on("valueChanged", function (args) {
                                        var value = args.value;
                    
                                        dataGrid.selectRows(value, false);
                                    });
                                    container.append($dataGrid);
                                    $("<div>").dxButton({
                                        text: "Close",
                    
                                        onClick: function (ev) {
                                            args.component.close();
                                        }
                                    }).css({ float: "right", marginTop: "10px" }).appendTo(container);
                                    return container;
                    
                                };
                            }
                        },
                        onToolbarPreparing: function(e) {
                            e.toolbarOptions.items.unshift({						
                                location: "after",
                                widget: "dxButton",
                                options: {
                                    hint: "Refresh Data",
                                    icon: "refresh",
                                    onClick: function() {
                                        dataGridApproverList.refresh();
                                    }
                                }
                            })
                        },
                        onDataErrorOccurred: function(e) {
                            // Menampilkan pesan kesalahan
                            console.log("Terjadi kesalahan saat memuat data (3):", e.error.message);
                    
                            // Memuat ulang DataGrid
                            dataGridApproverList.refresh();
                        }
                    })

                }
                else if(data.ID == 4) {
                    return $("<div id='formhistorylist'>").dxDataGrid({    
                        dataSource: storewithmodule('approverlisthistory',modelclass,reqid),
                        allowColumnReordering: true,
                        allowColumnResizing: true,
                        columnsAutoWidth: true,
                        rowAlternationEnabled: true,
                        wordWrapEnabled: true,
                        showBorders: true,
                        filterRow: { visible: false },
                        filterPanel: { visible: false },
                        headerFilter: { visible: false },
                        searchPanel: {
                            visible: true,
                            width: 240,
                            placeholder: 'Search...',
                        },
                        editing: {
                            useIcons:true,
                            mode: "cell",
                            allowAdding: false,
                            allowUpdating: false,
                            allowDeleting: false,
                        },
                        paging: { enabled: true, pageSize: 10 },
                        columns: [
                            {
                                dataField: "fullname"
                            },
                            {
                                caption: "Type",
                                dataField: "approvalType"
                            },
                            {
                                caption: "Date",
                                dataField: "approvalDate",
                                dataType: "datetime",
                                format: "dd-MM-yyyy hh:mm:ss",
                            },
                            {
                                caption: "Action",
                                dataField: "approvalAction",
                                encodeHtml: false,
                                allowFiltering: false,
                                allowHeaderFiltering: true,
                                customizeText: function (e) {
                                    var arrText = [
                                        "<span class='btn btn-secondary btn-xs'>Draft</span>",
                                        "<span class='btn btn-primary btn-xs'>Submitted</span>",
                                        "<span class='btn btn-warning btn-xs'>Rework</span>",
                                        "<span class='btn btn-success btn-xs'>Approved</span>",
                                        "<span class='btn btn-danger btn-xs'>Rejected</span>",
                                        "<span class='btn btn-secondary btn-xs'>Cancelled</span>",
                                    ];
                                    return arrText[e.value];
                                }
                            },
                            {
                                dataField: "remarks"
                            },
                        ],
                        export: {
                            enabled: false,
                            fileName: modname,
                            excelFilterEnabled: true,
                            allowExportSelectedData: true
                        },
                        onInitialized: function(e) {
                            dataGridApproverHistory = e.component;
                        },
                        onContentReady: function(e){
                            moveEditColumnToLeft(e.component);
                        },
                        onInitNewRow : function(e) {
                        },
                        onToolbarPreparing: function(e) {
                            e.toolbarOptions.items.unshift({						
                                location: "after",
                                widget: "dxButton",
                                options: {
                                    hint: "Refresh Data",
                                    icon: "refresh",
                                    onClick: function() {
                                        dataGridApproverHistory.refresh();
                                    }
                                }
                            })
                        },
                        onDataErrorOccurred: function(e) {
                            // Menampilkan pesan kesalahan
                            console.log("Terjadi kesalahan saat memuat data (4):", e.error.message);
                    
                            // Memuat ulang DataGrid
                            dataGridApproverHistory.refresh();
                        }
                    })
                }
                else if(data.ID == 6) {
                    return $("<div id='formstackholders'>").dxDataGrid({    
                        dataSource: storewithmodule('stackholders',modelclass,reqid),
                        allowColumnReordering: true,
                        allowColumnResizing: true,
                        columnsAutoWidth: true,
                        rowAlternationEnabled: true,
                        wordWrapEnabled: true,
                        showBorders: true,
                        filterRow: { visible: false },
                        filterPanel: { visible: false },
                        headerFilter: { visible: false },
                        searchPanel: {
                            visible: true,
                            width: 240,
                            placeholder: 'Search...',
                        },
                        editing: {
                            useIcons:true,
                            mode: "batch",
                            allowAdding: ((isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                            allowUpdating: ((isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                            allowDeleting: ((isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 ? true : false),
                        },
                        scrolling: {
                            mode: "virtual"
                        },
                        columns: [
                            {
                                caption: "Fullname",
                                dataField: "employee_id",
                                lookup: {
                                    dataSource: listOptionWeb('/list-getemployee/','id','fullname'),  
                                    valueExpr: 'id',
                                    displayExpr: 'fullname',
                                },
                                validationRules: [
                                    { 
                                        type: "required" 
                                    }
                                ]
                            },
                            {
                                dataField: "role",
                                lookup: {
                                    dataSource: ['User','Chairman'],
                                    searchEnabled: false
                                },
                                validationRules: [
                                    { 
                                        type: "required" 
                                    }
                                ]
                            },
                        ],
                        export: {
                            enabled: false,
                            fileName: modname,
                            excelFilterEnabled: true,
                            allowExportSelectedData: true
                        },
                        onInitialized: function(e) {
                            dataGridStackholders = e.component;
                        },
                        onContentReady: function(e){
                            moveEditColumnToLeft(e.component);
                        },
                        onInitNewRow : function(e) {
                        },
                        onEditorPreparing: function (e) {
                            if (e.dataField == "employee_id" && e.parentType == "dataRow") {
                                e.editorName = "dxDropDownBox";                
                                e.editorOptions.dropDownOptions = {                
                                    height: 500,
                                    width: 600
                                };
                                e.editorOptions.contentTemplate = function (args, container) {
                    
                                    var value = args.component.option("value"),
                                        $dataGrid = $("<div>").dxDataGrid({
                                            width: '100%',
                                            dataSource: args.component.option("dataSource"),
                                            keyExpr: "id",
                                            columns: ["companycode","fullname","departmentname"],
                                            hoverStateEnabled: true,
                                            paging: { enabled: true, pageSize: 10 },
                                            filterRow: { visible: true },
                                            height: '90%',
                                            showRowLines: true,
                                            showBorders: true,
                                            selection: { mode: "single" },
                                            selectedRowKeys: [value],
                                            focusedRowEnabled: true,
                                            focusedRowKey: args.component.option("value"),
                                            searchPanel: {
                                                visible: true,
                                                width: 265,
                                                placeholder: "Search..."
                                            },
                                            onSelectionChanged: function (selectedItems) {
                                                const keys = selectedItems.selectedRowKeys;
                                                const hasSelection = keys.length;
                                                args.component.option('value', hasSelection ? keys[0] : null);
                                                if(hasSelection !== 0) {
                                                    args.component.close();
                                                }
                                            }
                                        });
                    
                                    var dataGrid = $dataGrid.dxDataGrid("instance");
                    
                                    args.component.on("valueChanged", function (args) {
                                        var value = args.value;
                    
                                        dataGrid.selectRows(value, false);
                                    });
                                    container.append($dataGrid);
                                    $("<div>").dxButton({
                                        text: "Close",
                    
                                        onClick: function (ev) {
                                            args.component.close();
                                        }
                                    }).css({ float: "right", marginTop: "10px" }).appendTo(container);
                                    return container;
                    
                                };
                            }
                        },
                        onToolbarPreparing: function(e) {
                            e.toolbarOptions.items.unshift({						
                                location: "after",
                                widget: "dxButton",
                                options: {
                                    hint: "Refresh Data",
                                    icon: "refresh",
                                    onClick: function() {
                                        dataGridStackholders.refresh();
                                    }
                                }
                            })
                        },
                        onDataErrorOccurred: function(e) {
                            // Menampilkan pesan kesalahan
                            console.log("Terjadi kesalahan saat memuat data (6):", e.error.message);
                    
                            // Memuat ulang DataGrid
                            dataGridStackholders.refresh();
                        }
                    })

                }
            }
        })
    
    );

    scrollView.dxScrollView({
        width: '100%',
        height: '100%',
    })

    return scrollView;

};

const popupContentTemplateDetails = function (reqid,mode,options) {

    var taskID = options.data.id;
    const scrollView = $('<div />');

    scrollView.append("<hr>"),

    scrollView.append(

        $("<div>").dxAccordion({
            dataSource: accordionItemsDetails,
            animationDuration: 600,
            selectedItems: [accordionItemsDetails[0]],
            collapsible: true,
            multiple: true,
            itemTitleTemplate: function (data) {
                color = 'black';
                return '<small style="margin-bottom:10px !important; color:'+color+'">'+data.Title+'</small>'
            },
            itemTemplate: function (data) {
                if(data.ID == 1) {
                    return formData = $("<div id='formdata'>").dxDataGrid({    
                        dataSource: storewithmodule('momtaskdetail',modelclass,taskID),
                        allowColumnReordering: true,
                        allowColumnResizing: true,
                        columnsAutoWidth: true,
                        rowAlternationEnabled: false,
                        wordWrapEnabled: true,
                        showBorders: true,
                        showColumnLines:true,
                        filterRow: { visible: false },
                        filterPanel: { visible: false },
                        headerFilter: { visible: false },
                        searchPanel: {
                            visible: true,
                            width: 240,
                            placeholder: 'Search...',
                        },
                        sorting: {
                            mode: "none" // or "multiple" | "none"
                        },
                        editing: {
                            useIcons:true,
                            mode: "batch",
                            allowAdding: ((isMine == 1 && mode == 'view') ? true : (isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 || isChairman == 1 ? true : false),
                            allowUpdating: ((isMine == 1 && mode == 'view') ? true : (isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 || isChairman == 1 ? true : false),
                            allowDeleting: ((isMine == 1 && mode == 'view') ? true : (isMine == 1) && mode == 'edit' || mode == 'add' ) ? true : (admin == 1 || isChairman == 1 ? true : false),
                        },
                        pager: {
                            showPageSizeSelector: false,
                            allowedPageSizes: [5, 10],
                            showInfo: true
                        },
                        paging: { enabled: true, pageSize: 10 },
                        // scrolling: {
                        //     mode: "virtual"
                        // },
                        columns: [
                            {
                                dataField: 'description',
                                dataType: 'string',
                                validationRules: [{ type: "required" }]
                            },
                            {
                                dataField: 'section',
                                dataType: 'string',
                                validationRules: [{ type: "required" }]
                            },
                            {
                                dataField: 'status',
                                lookup: {
                                    dataSource: ['Open','Progress','Done'],
                                    searchEnabled: false
                                },
                                editorOptions: { 
                                    readOnly: (admin == 1) ? false : true
                                }
                            },
                            {
                                dataField: "completion_date",
                                dataType: "date",
                                format: "dd-MM-yyyy", 
                                editorOptions: { 
                                    readOnly: true
                                }
                            },
                            {
                                dataField: "deadline_date",
                                dataType: "date",
                                format: "dd-MM-yyyy", 
                                validationRules: [{ type: "required" }]
                            },
                            {
                                dataField: 'agings',
                                dataType: 'number',
                                editorOptions: { 
                                    readOnly: true
                                }
                            },
                            {
                                dataField: 'time_categorys',
                                dataType: 'string',
                                editorOptions: { 
                                    readOnly: true
                                },
                                encodeHtml: false,
                                customizeText: function (e) {
                                    if(e.value == '< 4 Weeks') {
                                        var dataTC = "<span class='btn btn-success btn-xs btn-status'>"+e.value+"</span>"
                                    } else if(e.value == '4-6 Weeks') {
                                        var dataTC = "<span class='btn btn-warning btn-xs btn-status'>"+e.value+"</span>"
                                    } else {
                                        var dataTC = "<span class='btn btn-danger btn-xs btn-status'>"+e.value+"</span>"
                                    }
                                    return dataTC;
                                },
                            },
                            {
                                caption: 'Action',
                                width: 140,
                                cellTemplate: function(container, options) {
                                    var taskID = options.data.id;

                                    if(options.data.status == 'Progress') {
                                        $('<button class="btn btn-info"><i class="fa fa-check"></i></button>').on('dxclick', function(evt) {
                                            evt.stopPropagation();
                                            popupactions.option({
                                                contentTemplate: () => popupContentTemplateActions(taskID,'approval',options),
                                            });
                                            popupactions.show();
                                        }).appendTo(container);
                                    }
                                },
                                visible: (isMine == 1 || admin == 1 || isChairman == 1) ? true : false
                            },
                        ],
                        masterDetail: {
                            enabled: true,
                            autoExpandAll: false,
                            template: masterDetailTemplate,
                        },
                        export: {
                            enabled: false,
                            fileName: modname+'_taskdetail',
                            excelFilterEnabled: true,
                            allowExportSelectedData: true
                        },
                        onInitialized: function(e) {
                            dataGridtaskdetail = e.component;
                        },
                        onContentReady: function(e){
                            moveEditColumnToLeft(e.component);
                        },
                        onInitNewRow : function(e) {
                        },
                        onToolbarPreparing: function(e) {
                            e.toolbarOptions.items.unshift({						
                                location: "after",
                                widget: "dxButton",
                                options: {
                                    hint: "Refresh Data",
                                    icon: "refresh",
                                    onClick: function() {
                                        dataGridtaskdetail.refresh();
                                    }
                                }
                            });
                        },
                        onEditorPreparing: function (e) {
                        },
                        onCellPrepared: function (e) {
                        },
                        onDataErrorOccurred: function(e) {
                            // Menampilkan pesan kesalahan
                            console.log("Terjadi kesalahan saat memuat data (1):", e.error.message);
                    
                            // Memuat ulang DataGrid
                            dataGridtaskdetail.refresh();
                        }
                    })
                } 
            }
        })
    
    );

    scrollView.dxScrollView({
        width: '100%',
        height: '100%',
    })

    return scrollView;

};

const popupContentTemplateActions = function (reqid,mode,options) {

    const scrollView = $('<div />');

    var approvalOptions = 
        '<div class="row">' +
            '<div class="col-md-6">' +
                '<label for="remarks">Approval Action :</label>' +
                '<div class="form-check">'+
                    '<input class="form-check-input" type="radio" name="approvalaction" id="rappraction1" value="3">'+
                    '<label class="form-check-label" for="rappraction1">'+
                    'Completed'+
                    '</label>'+
                '</div>'+
                '<div class="form-check">'+
                    '<input class="form-check-input" type="radio" name="approvalaction" id="rappraction2" value="2">'+
                    '<label class="form-check-label" for="rappraction2">'+
                    'Reworked'+
                    '</label>'+
                '</div>'+
            '</div>' +
            '<div class="col-md-6">' +
                '<div class="form-group">' +
                    '<label for="remarkstaskactions">Remarks :</label>' +
                    '<textarea class="form-control" id="remarkstaskactions" rows="3"></textarea>' +
                '</div>' +
            '</div>' +
        '</div><hr>';
    
    scrollView.append('<div class="row">' +
    '<div class="col-lg-12">' +
        '<div class="card">' +
        '<div class="card-header">' +
            '<h5 class="card-title">Form Action</h5>' +
        '</div>' +
        '<div class="card-body" style="border-bottom-color: darkseagreen !important;border-left-color: darkseagreen;">' +
            approvalOptions +
            '<button id="btn-actionstatus" type="button" onClick="btnreqactionstatus('+reqid+',\''+mode+'\')" class="btn btn-success waves-effect btn-label waves-light m-1"><i class="bx bx-check-double label-icon"></i> Release</button>'+
        '</div>' +
        '</div>' +
    '</div>' +
    '</div>');
    
    scrollView.dxScrollView({
        width: '100%',
        height: '100%',
    })

    return scrollView;

};

function masterDetailTemplate(_, masterDetailOptions) {
    return $('<div>').dxTabPanel({
      items: [{
        title: 'Update',
        template: createUpdateTabTemplate(masterDetailOptions.data),
      }, {
        title: 'PIC',
        template: createPICTabTemplate(masterDetailOptions.data),
      }],
    });
}

function createUpdateTabTemplate(masterDetailData) {
    return function () {
        return formData = $("<div>").dxDataGrid({    
            dataSource: storewithmodule('momtaskupdate',modelclass,masterDetailData.id),
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnsAutoWidth: true,
            rowAlternationEnabled: true,
            wordWrapEnabled: true,
            showBorders: true,
            filterRow: { visible: false },
            filterPanel: { visible: false },
            headerFilter: { visible: false },
            searchPanel: {
                visible: false,
                width: 240,
                placeholder: 'Search...',
            },
            sorting: {
                mode: "none" // or "multiple" | "none"
            },
            editing: {
                useIcons:true,
                mode: "form",
                allowAdding: true,
                allowUpdating: true,
                allowDeleting: true,
                popup: {
                    title: "Update Task",
                    showTitle: true,
                    width: 700,
                    height: 525,
                    position: {
                        my: "center",
                        at: "center",
                        of: window
                    },
                    toolbarItems: [
                        {
                            toolbar: 'bottom',
                            location: 'after',
                            widget: 'dxButton',
                            options: {
                                onClick: function(e) {
                                    if($adafile) {
                                        DevExpress.ui.notify("Harap selesaikan unggahan Anda sebelum menyimpan data","error");
                                        e.cancel = true;
                                    } else {
                                        dataGridTaskUpdate.saveEditData();
                                    }
                                },
                                text: 'Simpan'
                            }
                        },
                        {
                            toolbar: 'bottom',
                            location: 'after',
                            widget: 'dxButton',
                            options: {
                                onClick: function(e) {
                                    dataGridTaskUpdate.cancelEditData();
                                },text: 'Batal'
                            }
                        }
                    ]
                },
                form: {
                    items: [{
                        itemType: "group",
                        colCount: 2,
                        colSpan: 2,
                        items: [
                            {
                                dataField: "description",
                            },
                            // {
                            //     dataField: "date",
                            // },
                        ]
                    },
                    {
                        itemType: "group",
                        colCount: 2,
                        colSpan: 2,
                        caption: "Supporting Document",
                        items: [{
                          dataField: "filename",
                          colSpan: 2
                        }]
                    }
                ]},
            },
            scrolling: {
                mode: "virtual"
            },
            columns: [
                {
                    dataField: 'description',
                    validationRules: [{ type: "required" }]

                },
                {
                    dataField: "date",
                    dataType: "date",
                    format: "dd-MM-yyyy",
                    // sortOrder: "asc",
                    width: 140,
                    editorOptions: { 
                        readOnly: true
                    }
                },
                {
                    caption: "Supporting Document",
                    dataField: "filename",
                    width: 240,
                    allowFiltering: false,
                    allowSorting: false,
                    cellTemplate: cellTemplate,
                    editCellTemplate: editCellTemplate,
                },
                {
                    dataField: 'updated_by',
                    width: 140,
                    lookup: {
                        dataSource: listOption('/list-employee','id','fullname'),  
                        valueExpr: 'id',
                        displayExpr: 'fullname',
                    },
                    editorOptions: { 
                        readOnly: true
                    }
                },
            ],
            export: {
                enabled: false,
                fileName: modname,
                excelFilterEnabled: true,
                allowExportSelectedData: true
            },
            onInitialized: function(e) {
                dataGridTaskUpdate = e.component;
            },
            onContentReady: function(e){
                moveEditColumnToLeft(e.component);
            },
            onInitNewRow : function(e) {
            },
            onToolbarPreparing: function(e) {
               
            },
            onEditorPreparing: function (e) {
            },
            onCellPrepared: function (e) {
            },
            onDataErrorOccurred: function(e) {
                // Menampilkan pesan kesalahan
                console.log("Terjadi kesalahan saat memuat data (1):", e.error.message);
        
                // Memuat ulang DataGrid
                dataGridtaskdetail.refresh();
            }
        })
    };
}

function createPICTabTemplate(masterDetailData) {
    return function () {
        return formData = $("<div>").dxDataGrid({    
            dataSource: storewithmodule('momtaskbound',modelclass,masterDetailData.id),
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnsAutoWidth: true,
            rowAlternationEnabled: true,
            wordWrapEnabled: true,
            showBorders: true,
            filterRow: { visible: false },
            filterPanel: { visible: false },
            headerFilter: { visible: false },
            searchPanel: {
                visible: false,
                width: 240,
                placeholder: 'Search...',
            },
            sorting: {
                mode: "none" // or "multiple" | "none"
            },
            editing: {
                useIcons:true,
                mode: "batch",
                allowAdding: true,
                allowUpdating: true,
                allowDeleting: true,
            },
            scrolling: {
                mode: "virtual"
            },
            columns: [
                {
                    caption: 'Role',
                    dataField: 'content',
                    lookup: {
                        dataSource: ['PIC','Supervisor','Support'],
                        searchEnabled: false
                    },
                    sortOrder: "asc",
                    validationRules: [{ type: "required" }]

                },
                {
                    caption: "Employee",
                    dataField: "employee_id",
                    lookup: {
                        dataSource: listOption('/list-employee','id','fullname'),  
                        valueExpr: 'id',
                        displayExpr: 'fullname',
                    },
                    validationRules: [
                        { 
                            type: "required" 
                        }
                    ]
                },
            ],
            export: {
                enabled: false,
                fileName: modname,
                excelFilterEnabled: true,
                allowExportSelectedData: true
            },
            onInitialized: function(e) {
                dataGridTaskBound = e.component;
            },
            onContentReady: function(e){
                moveEditColumnToLeft(e.component);
            },
            onInitNewRow : function(e) {
            },
            onToolbarPreparing: function(e) {
               
            },
            onEditorPreparing: function (e) {
                if (e.dataField == "employee_id" && e.parentType == "dataRow") {
                    e.editorName = "dxDropDownBox";            
                    e.editorOptions.dropDownOptions = {                
                        height: 500,
                        width: 600
                    };
                    e.editorOptions.contentTemplate = function (args, container) {
        
                        var value = args.component.option("value"),
                            $dataGrid = $("<div>").dxDataGrid({
                                width: '100%',
                                dataSource: args.component.option("dataSource"),
                                keyExpr: "id",
                                columns: ["sapid","fullname","companycode","departmentname"],
                                hoverStateEnabled: true,
                                paging: { enabled: true, pageSize: 10 },
                                filterRow: { visible: true },
                                height: '90%',
                                showRowLines: true,
                                showBorders: true,
                                selection: { mode: "single" },
                                selectedRowKeys: [value],
                                focusedRowEnabled: true,
                                focusedRowKey: args.component.option("value"),
                                searchPanel: {
                                    visible: true,
                                    width: 265,
                                    placeholder: "Search..."
                                },
                                onSelectionChanged: function (selectedItems) {
                                    const keys = selectedItems.selectedRowKeys;
                                    const hasSelection = keys.length;
                                    args.component.option('value', hasSelection ? keys[0] : null);
                                    if(hasSelection !== 0) {
                                        args.component.close();
                                    }
                                }
                            });
        
                        var dataGrid = $dataGrid.dxDataGrid("instance");
        
                        args.component.on("valueChanged", function (args) {
                            var value = args.value;
        
                            dataGrid.selectRows(value, false);
                        });
                        container.append($dataGrid);
                        $("<div>").dxButton({
                            text: "Close",
        
                            onClick: function (ev) {
                                args.component.close();
                            }
                        }).css({ float: "right", marginTop: "10px" }).appendTo(container);
                        return container;
        
                    };
                }
            },
            onCellPrepared: function (e) {
            },
            onDataErrorOccurred: function(e) {
                // Menampilkan pesan kesalahan
                console.log("Terjadi kesalahan saat memuat data (1):", e.error.message);
        
                // Memuat ulang DataGrid
                dataGridtaskdetail.refresh();
            }
        })
    };
}

function runpopup() {
    popup = $('#popup').dxPopup({
        contentTemplate: popupContentTemplate,
        container: '.content',
        showTitle: true,
        title: 'Submission Detail',
        visible: false,
        dragEnabled: false,
        hideOnOutsideClick: false,
        showCloseButton: true,
        fullScreen : false,
        onShowing: function(e) {
        },
        onShown: function(e) {
        },
        onHidden: function(e) {
            dataGrid.refresh();
        },
        toolbarItems: [
            {
                widget: 'dxButton',
                toolbar: 'bottom',  // Set the button to the bottom toolbar
                location: 'after',
                options: {
                    text: "Fullscreen",
                    onClick: function() {
                        if (popup.option("fullScreen")) {
                            popup.option("fullScreen", false);
                            this.option("text", "Enable Fullscreen");
                        } else {
                            popup.option("fullScreen", true);
                            this.option("text", "Disable Fullscreen");
                        }
                    }
                }
            },
            {
                widget: 'dxButton',
                toolbar: 'bottom',
                location: 'after',
                options: {
                    text: 'Close',
                    onClick() {
                        popup.hide();
                    },
                },
            }
        ]

    }).dxPopup('instance');
}

function runpopupdetails() {
    popupdetails = $('#popupdetails').dxPopup({
        contentTemplate: popupContentTemplateDetails,
        container: '.content',
        showTitle: true,
        title: 'Task Detail',
        visible: false,
        dragEnabled: false,
        hideOnOutsideClick: false,
        showCloseButton: true,
        fullScreen : true,
        onShowing: function(e) {
        },
        onShown: function(e) {
        },
        onHidden: function(e) {
            // dataGrid.refresh();
            dataGridApproverHistory.refresh();
            dataGriddetail.refresh();
        },
        toolbarItems: [
        {
            widget: 'dxButton',
            toolbar: 'bottom',
            location: 'after',
            options: {
            text: 'Close',
            onClick() {
                popupdetails.hide();
            },
            },
        }]

    }).dxPopup('instance');
}

function runpopupactions() {
    popupactions = $('#popupactions').dxPopup({
        contentTemplate: popupContentTemplateActions,
        container: '.content',
        showTitle: true,
        title: 'Task Action',
        visible: false,
        dragEnabled: false,
        hideOnOutsideClick: false,
        showCloseButton: true,
        fullScreen : false,
        onShowing: function(e) {
        },
        onShown: function(e) {
        },
        onHidden: function(e) {
            dataGridtaskdetail.refresh();
        },
        toolbarItems: [
        {
            widget: 'dxButton',
            toolbar: 'bottom',
            location: 'after',
            options: {
            text: 'Close',
            onClick() {
                popupactions.hide();
            },
            },
        }]

    }).dxPopup('instance');
}

function btnreqsubmit(reqid,mode) {

    var btnSubmit = $('#btn-submit');
    btnSubmit.prop('disabled', true);
    var actionForm = (mode == 'approval') ? 'approval' : 'submission';

    if(mode == 'approval') {
        var valapprovalAction = $('input[name="approvalaction"]:checked').val(); // mengambil nilai dari radio button
        var valremarks = $('#remarks').val(); // mengambil nilai dari text area
        if (!valapprovalAction) {
            alert('Please select approval action.')
            btnSubmit.prop('disabled', false);
            return false;
        }
        else if (!valremarks) {
            alert('Please enter remarks.')
            btnSubmit.prop('disabled', false);
            return false;
        }
        
    }

    var valApprovalType = valapprovalAction == 3 ? 'Approved' : valapprovalAction == 2 ? 'Reworked' : valapprovalAction == 4 ? 'Rejected' : '';

    var result = confirm('Are you sure you want to send this submission ?');
    if (result) {
        sendRequest(apiurl + "/submissionrequest/"+reqid+"/"+modelclass, "POST", {
            requestStatus:1,
            action: actionForm,
            approvalAction: (valapprovalAction == null) ? 1 : parseInt(valapprovalAction),
            approvalType: valApprovalType,
            remarks: valremarks
        }).then(function(response){
            if(response.status == 'error') {
                btnSubmit.prop('disabled', false);
            } else {
                popup.hide();
            }
        });
    } else {
        btnSubmit.prop('disabled', false);
        alert('Cancelled.');
    }

}

function btnreqactionstatus(reqid,mode) {
    var btnSubmit = $('#btn-actionstatus');
    btnSubmit.prop('disabled', true);

    if(mode == 'approval') {
        var valapprovalAction = $('input[name="approvalaction"]:checked').val(); // mengambil nilai dari radio button
        console.log(valapprovalAction)
        var valremarks = $('#remarkstaskactions').val(); // mengambil nilai dari text area
        console.log(valremarks)
        if (!valapprovalAction) {
            alert('Please select approval action.')
            btnSubmit.prop('disabled', false);
            return false;
        }
        else if (!valremarks) {
            alert('Please enter remarks.')
            btnSubmit.prop('disabled', false);
            return false;
        }
        
    }

    var statusAction = valapprovalAction == 3 ? 'Completed' : valapprovalAction == 2 ? 'Reworked' : '';

    var result = confirm('Are you sure you want to submit this action ?');
    if (result) {
        sendRequest(apiurl + "/taskapproval/"+reqid+"/"+modelclass, "POST", {
            // action: actionForm,
            // approvalAction: (valapprovalAction == null) ? 1 : parseInt(valapprovalAction),
            status: statusAction,
            remarks: valremarks
        }).then(function(response){
            if(response.status == 'error') {
                btnSubmit.prop('disabled', false);
            } else {
                popupactions.hide();
            }
        });
    } else {
        btnSubmit.prop('disabled', false);
        alert('Cancelled.');
    }

}

function cellTemplate(container, options) {
    if(options.value !== null) {
        container.append('<a href="public/upload/'+options.value+'" target="_blank"><img src="public/assets/images/showfile.png" height="50" width="70"></a>');
    }
}

function editCellTemplate(cellElement, cellInfo) {
    let buttonElement = document.createElement("div");
    buttonElement.classList.add("retryButton");
    let retryButton = $(buttonElement).dxButton({
      text: "Retry",
      visible: false,
      onClick: function() {
        // The retry UI/API is not implemented. Use a private API as shown at T611719.
        for (var i = 0; i < fileUploader._files.length; i++) {
          delete fileUploader._files[i].uploadStarted;
        }
        fileUploader.upload();
      }
    }).dxButton("instance");

    $path = "";
    $adafile = "";
    let fileUploaderElement = document.createElement("div");
    let fileUploader = $(fileUploaderElement).dxFileUploader({
      multiple: false,
      accept: ".pptx,.ppt,.doc,.docx,.pdf,.xlsx,.xls,.csv,.png,.jpg,.jpeg,.zip",
      uploadMode: "instantly",
      name: "myFile",
      uploadUrl: apiurl + "/upload-berkas/"+modname,
      onValueChanged: function(e) {
        let reader = new FileReader();
        reader.onload = function(args) {
          imageElement.setAttribute('src', args.target.result);
        }
        reader.readAsDataURL(e.value[0]); // convert to base64 string
      },
      onUploaded: function(e){
       
        let path = e.request.response;

        const unsafeCharacters = /[#"%<>\\^`{|}]/g;
        let unsafeFound = path.match(unsafeCharacters);

        if (unsafeFound) {
            let unsafeCharactersString = unsafeFound.join(', ');
            DevExpress.ui.dialog.alert(
                `The file name contains these unsafe characters: ${unsafeCharactersString}. Please rename the file to continue.`,
                "error"
            );
        
            path = "";
            retryButton.option("visible", true);
        } else {
            cellInfo.setValue(e.request.responseText);
            retryButton.option("visible", false);
        }

      },
      onUploadError: function(e){
          $path = "";
          DevExpress.ui.notify(e.request.response,"error");
      }
    }).dxFileUploader("instance");
  
    // let imageElement = document.createElement("img");
    //     imageElement.classList.add("uploadedImage");
    //     imageElement.setAttribute('src', "upload/" +cellInfo.value);
    //     imageElement.setAttribute('height', "50");
        
    //     cellElement.append(imageElement);
        cellElement.append(fileUploaderElement);
        cellElement.append(buttonElement);
  
  }