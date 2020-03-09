
export default class Services {
	/**
	* Client errors response codes
	*
	* 400 - Bad Response Error
	* 401 - Authorization Response Error
	* 403 - Forbidden Response Error
	* 422 - Validation Response Error
	**/
	static get S400(){ return 400; }
	static get S401(){ return 401; }
	static get S403(){ return 403; }
	static get S404(){ return 404; }
	static get S422(){ return 422; }

	/**
	* Server errors response codes
	*
	* 500 - Server Response Error
	**/
	static get S500(){ return 500; }

	/**
	* Successful response codes
	*
	* 200 - OK Response
	* 201 - Created Response
	**/
	static get S200(){ return 200; }
	static get S201(){ return 201; }


	/**
	* Handle Http Response
	*
	**/
	static handle(context, response, callback){
		let status = response.status;

		// log the response to console
		Services.log(status, response);

		switch(status){
			case Services.S400:
				Services.handleS400(context, status, response, callback);
			break;
			case Services.S401:
				Services.handleS401(context, status, response, callback);
			break;
			case Services.S403:
				Services.handleS403(context, status, response, callback);
			break;
			case Services.S404:
				Services.handleS404(context, status, response, callback);
			break;
			case Services.S422:
				Services.handleS422(context, status, response, callback);
			break;
			case Services.S500:
				Services.handleS500(context, status, response, callback);
			break;
			case Services.S200:
				Services.handleS200(context, status, response, callback);
			break;
			case Services.S201:
				Services.handleS201(context, status, response, callback);
			break;
			default:
				Services.handleS500(context, status, response, callback);
		}
	}

	/**
	* Handle 400 Http Response
	*
	**/
	static handleS400(context, status, response, callback){
		let message = response.data.message;

		if(_.isFunction(callback)){
			callback({ message, status, response });
		}else{
			Notify.send(context, { message , type : 'danger'});
		}
	}

	/**
	* Handle 401 Http Response
	*
	**/
	static handleS401(context, status, response, callback){
		let message = response.data.message;

		if(_.isFunction(callback)){
			callback({ message, status, response });
		}else{
			Notify.send(context, { message , type : 'danger'});
			location.reload();
		}
	}

	/**
	* Handle 403 Http Response
	*
	**/
	static handleS403(context, status, response, callback){
		let message = response.data.message;

		if(_.isFunction(callback)){
			callback({ message, status, response });
		}else{
			Notify.send(context, { message , type : 'danger'});
		}
	}

	/**
	* Handle 404 Http Response
	*
	**/
	static handleS404(context, status, response, callback){
		let message = response.data.message;

		if(_.isFunction(callback)){
			callback({ message, status, response });
		}else{
			Notify.send(context, { message , type : 'danger'});
		}
	}

	/**
	* Handle 422 Http Response
	*
	**/
	static handleS422(context, status, response, callback){
		let message = response.data.message;
		let errors = response.data.errors;

		if(!_.isEmpty(errors)){
			let keys = _.head(_.keys(errors));

			if(keys != 0){
				message = _.head(errors[keys]);
			}
		}

		if(_.isFunction(callback)){
			callback({ message, status, response });
		}else{
			Notify.send(context, { message , type : 'danger'});
		}
	}

	/**
	* Handle 500 Http Response
	*
	**/
	static handleS500(context, status, response, callback){
		let message = "Something went wrong, please try again later.";
		let description = response.data.message;

		if(_.isFunction(callback)){
			callback({ message, status, description, response });
		}else{
			Notify.send(context, { message: message, type: 'danger' });
		}
	}

	/**
	* Handle 200 Http Response
	*
	**/
	static handleS200(context, status, response, callback){
		let data = response.data;
		let message = response.data.message;

		if(_.isFunction(callback)){
			callback({ data, message, status, response });
		}
	}

	/**
	* Handle 201 Http Response
	*
	**/
	static handleS201(context, status, response, callback){
		let data = response.data;
		let message = response.data.message;

		if(_.isFunction(callback)){
			callback({ data, message, status, response });
		}
	}

	static log(status, response){
		if(env == 'local' || env == 'staging'){
			console.log(`Response Status Code ${status}`, response);
		}
	}
}
