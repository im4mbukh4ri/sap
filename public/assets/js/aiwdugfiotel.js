Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
Vue.http.options.emulateJSON = true;

Vue.component('list-hotels',{
  template:'#listHotel',
  props:['hotels','results'],
  data:function(){
    return {
      showModal:false,
      request:window.request,
      keyword:'',
      myHotels:[],
      error_code:false,
      error_msg:'',
      myNext:null,
      imgLoad:false,
      busy:false,
      hotelsDetail:window.url_detail,
      token:Vue.http.headers.common['X-CSRF-TOKEN'],
      imgDefault:'/assets/images/material/unavailable.jpg',
      sort:''
    }
  },
  computed:{
    next:{
      get:function(){
        if(this.myNext==null&&this.results!='undefined'&&this.results!=null){
          return this.results.next;
        }else{
          return this.myNext;
        }
      },
      set:function(next){
        this.myNext=next;
        return this.myNext;
      }
    },
    resultHotels:{
      get:function() {
        if(this.myHotels.length!=0){
          return this.myHotels;
        }
        this.load=true;
        this.myHotels=this.hotels;
        return this.hotels;
      },
      set:function(hotels){
        this.myHotels=this.hotels;
        this.myHotels=hotels;
      }

    },
    sortedUpperPrice: function () {
      function compare (a, b) {
        if (a.price < b.price)
          return 1;
        if (a.price > b.price)
          return -1;
        return 0;
      }

      this.myHotels.sort(compare);
      return this.resultHotels=this.myHotels;
    },
    sortedLowerPrice: function () {
      function compare (a, b) {
        if (a.price < b.price)
          return -1;
        if (a.price > b.price)
          return 1;
        return 0;
      }

      this.myHotels.sort(compare);
      return this.resultHotels=this.myHotels;
    },
    sortedLowerRate: function () {
      function compare (a, b) {
        if (a.star < b.star)
          return -1;
        if (a.star > b.star)
          return 1;
        return 0;
      }

      this.myHotels.sort(compare);
      return this.resultHotels=this.myHotels;
    },
    sortedUpperRate: function () {
      function compare (a, b) {
        if (a.star < b.star)
          return 1;
        if (a.star > b.star)
          return -1;
        return 0;
      }
      this.myHotels.sort(compare);
      return this.resultHotels=this.myHotels;
    }
  },
  methods: {
    showLoad:function(){
      this.showModal=true
    },
    addCommas:function (nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    },
    onSubmit:function(){
      this.showModal=true;
      this.request.keyword=this.keyword;
      this.request.next=this.results.next;
      this.$http.post(window.url_keyword,this.request).then((response)=>{
        if(response.body.error_code=="000"){
          this.error_code=false;
          this.error_msg='';
          this.resultHotels=response.body.hotels;
          this.next=response.body.next;
        }else{
          this.error_code=true;
          this.error_msg='Tidak ditemukan hotel dengan keyword \"'+this.keyword+'\"';
        }
        this.showModal=false;
          // $('#success').append(response.data).fadeIn("slow");
  },(response)=>{
          //$(loader).hide();
          console.log(response.status);
      })
    },
    loadMore:function(){
      if(this.results!=null&&this.results.error_code=='000'){
        this.busy=true;
        if(this.next!=""){
          this.request.next=this.next;
          this.imgLoad=true;
          this.$http.post(window.url_next,this.request).then((response)=>{
            if(response.body.error_code=="000"){
              this.error_code=false;
              this.error_msg='';
              this.resultHotels=this.myHotels.concat(response.body.hotels);
              this.next=response.body.next;
              if(this.next!=""){
                this.busy=false;
              }
            }else{


            }
            this.imgLoad=false;
      },(response)=>{
              console.log(response.status);
          })
        }
      }
    },
    sortBy: function (sort,type) {
      this.showModal=true;
      this.request.sort_by= sort;
      this.request.type=type;
      //this.hotels = [];
      //this.myHotels = [];
      //this.resultHotels = [];
      //this.imgLoad=true;
      this.request.next=this.next;
      this.$http.post(window.url_sort,this.request).then((response)=>{
            if(response.body.error_code=="000"){
              this.showModal=false;
              this.error_code=false;
              this.error_msg='';
              this.resultHotels=this.myHotels.concat(response.body.hotels);
              this.next=response.body.next;
              this.resultHotels=response.body.hotels;
            }else{


            }
            this.imgLoad=false;
            },(response)=>{
              console.log(response.status);
          })
    },
    sortOnChange: function () {
      switch (Number(this.sort)){
        case 1:
          this.sortBy('startprice','ASC');
          break;
        case 2:
          this.sortBy('startprice','DESC');
          break;
        case 3:
          this.sortBy('rating','ASC');
          break;
        case 4:
          this.sortBy('rating','DESC');
          break;
        case 5:
          this.sortBy('hotelname','ASC');
          break;
        case 6:
          this.sortBy('hotelname','DESC');

      }
    },
    sortir: function () {
      switch (Number(this.sort)) {
        case 1:
          this.sortedLowerPrice;
          break;
        case 2:
          this.sortedUpperPrice;
          break;
        case 3:
          this.sortedLowerRate;
          break;
        case 4:
          this.sortedUpperRate;
          break;
      }
    }
  }
});
var hotel = new Vue({
    el:'#hotel',
    data:{
        results:null,
        hotels:[],
        showModal:false
    },
    methods:{
        search:function(url,body,loader){
            this.$http.post(url,body).then((response)=>{
                $(loader).hide();
                this.results=response.body;
                this.hotels=response.body.hotels;
        },(response)=>{
                //$(loader).hide();
            })
        },
        mySubmit:function(){
            this.showModal=true;
        },
        onSubmit:function(){
        }
    }
});
