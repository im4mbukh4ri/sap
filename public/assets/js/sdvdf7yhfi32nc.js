Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
Vue.http.options.emulateJSON = true;

Vue.component('modal', {
    template: '#modal-template'
})
function airlinesCodeUpdate(keyValue, newKey, newValue)
{
    keyValue.Key = newKey;
    keyValue.Value = newValue;
}
var airlines = new Vue({
    el:'#app',
    data:{
        results:null,
        showModal:false
    },
    methods:{
        getSchedule:function(url,body,loader){
            this.$http.post(url,body).then((response)=>{

            if(typeof response.data.departure !== 'undefined'){
                $("#loadAll").hide();
                $('#departure').append(response.data.departure).fadeIn("slow");
                $('#return').append(response.data.return).fadeIn("slow");
            }else{
                $("#load").hide();
                $('#success').append(response.data).fadeIn("slow");
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
