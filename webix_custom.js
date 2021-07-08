webix.protoUI({
    name:"cust_datatable",
    defaults: {
      leftSplit: 0,
      rightSplit: 0,
      topSplit: 0,
      columnWidth: 100,
      sort: true,
      prerender: false,
      autoheight: false,
      autowidth: false,
      header: true,
      fixedRowHeight: true,
      scrollAlignY: true,
      scrollX: true,
      scrollY: true,
      datafetch: 50,
      navigation: true,
      scheme:{
        $change:function(item){
          if (item.id % 2 == 0)
          item.$css = "row_even";
        }
      }
    }
}, webix.ui.datatable);