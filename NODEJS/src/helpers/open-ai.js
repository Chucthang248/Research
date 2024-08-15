const OpenAI = require('openai');
const createFeatureLogger = require('./logger');
const logOrg = createFeatureLogger('organizationAndProject');
const logAuth = createFeatureLogger('Authetication');

/**
 * orgAndProject
 */
let orgAndProject = () => {
    try {
        const openai = new OpenAI({
            apiKey: process.env.OPENAI_SECRET_KEY,
            organization: process.env.OPENAI_ORGANIZATION_ID,
            project: process.env.OPENAI_PROJECT_ID,
        });
        return openai;
    } catch (error) {
        logOrg.error(error.message);
        return false;
    }
}

/**
 * Threads
 * @param {string} type - method of thread
 */
let threads = (type) => {
    switch (type) {
        case 'create':
            break;
        case 'retrieve':
            break;
        case 'modify':
            break;
        case 'delete':
            break;  
        default:
            break;
    }
}

/**
 * Threads
 * @param {string} type - method of thread
 */
let assistants = (type) => {
    switch (type) {
        case 'create':
            break;
        case 'retrieve':
            break;
        case 'modify':
            break;
        case 'list':
            break;
        case 'delete':
            break;  
        default:
            break;
    }
}

let chatComplete = () => {

}

module.exports = {
    orgAndProject,
    chatComplete: chatComplete,
    assistants: assistants,
    threads: threads
 }
