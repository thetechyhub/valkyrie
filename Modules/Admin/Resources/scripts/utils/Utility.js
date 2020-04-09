import Modules from "@/store/modules";
import store from "@/store";

export default class Utility {

	static truncate(text, length, clamp){
		clamp = clamp || '...';
		var node = document.createElement('div');
		node.innerHTML = text;
		var content = node.textContent;

		return content.length > length ? content.slice(0, length) + clamp : content;
	}

	static moneyFormat(number, options){
		let config = {
			decimals: options.decimals || 2,
			thousand: ',',
			prefix: options.currency || 'MYR '
		};

		if (!(number instanceof Number)) {
			number = Number(number);
		}
		Math.round(number * 100) / 100;

		let formater = wNumb(config);

		return formater.to(number);
	}

	static moneyToNumber(number, options){
		let config = {
			decimals: options.decimals || 2,
			thousand: ',',
			prefix: options.currency || 'MYR '
		};

		let formater = wNumb(config);

		return formater.from(number);
	}

	static UUID(){
		var d = new Date().getTime();
		if (typeof performance !== 'undefined' && typeof performance.now === 'function'){
				d += performance.now(); //use high-precision timer if available
		}
		var newGuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
				var r = (d + Math.random() * 16) % 16 | 0;
				d = Math.floor(d / 16);
				return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
		});

		return newGuid;
	}

	static dispatchModulesActions(actionName, { modules = Modules, modulePrefix = '', flags = {} } = {}){ 
		for (const moduleName in modules) {
			const moduleDefinition = modules[moduleName]
			// If the action is defined on the module...
			if (moduleDefinition.actions && moduleDefinition.actions[actionName]) {
				// Dispatch the action if the module is namespaced. Otherwise,
				// set a flag to dispatch the action globally at the end.
				if (moduleDefinition.namespaced) {
					store.dispatch(`${modulePrefix}${moduleName}/${actionName}`)
				} else {
					flags.dispatchGlobal = true
				}
			}

			// If there are any nested sub-modules...
			if (moduleDefinition.modules) {
				// Also dispatch the action for these sub-modules.
				dispatchActionForAllModules(actionName, {
					modules: moduleDefinition.modules,
					modulePrefix: modulePrefix + moduleName + '/',
					flags,
				})
			}
		}
	}
}
