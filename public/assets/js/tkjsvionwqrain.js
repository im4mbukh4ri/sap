Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
Vue.http.options.emulateJSON = true;

Vue.component('modal', {
    template: '#modal-template'
});
var trains = new Vue({
    el:'#train',
    data:{
        results:null,
        showModal:false
    },
    methods:{
        getSchedule:function(url,body,loader){
            this.$http.post(url,body).then((response)=>{
            if(typeof response.data.departure !== 'undefined'){
              // console.log("Masuk return");
                $(loader).hide();
                $('#departure').append(response.data.departure).fadeIn("slow");
                $('#return').append(response.data.return).fadeIn("slow");

            }else{
            //     $(loader+'class').hide();
                $('#success').append(response.data).fadeIn("slow");
                $(loader).hide();
            }
        },(response)=>{
                //$(loader).hide();
            })
        },
        mySubmit:function(){
            this.showModal=true;
        }
    }
});
