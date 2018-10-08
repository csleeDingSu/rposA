
var app = new Vue({
    el:'#test',
    data: {
        newMessage : '',
        message: 'hello1',
        sample1: [1,2,3,4,5]
    },

    methods: {
        add() {

            this.sample1.push(this.newMessage);
            this.newMessage = '';

        },
        invitationLink() {
            alert('http://192.168.1.154/register/c7tyF9FVII');
        }
    },

       mounted() {
    //alert('ready');
       }

})
