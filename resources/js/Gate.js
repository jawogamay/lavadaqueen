export default class Gate{

    constructor(user){
        this.user = user;
    }


    admin(){
        return this.user.type === 'Admin';
    }

    customer(){
        return this.user.type === 'Customer';
    }
   
   laundry(){
        return this.user.type === 'Laundry Shop';
   }


}

