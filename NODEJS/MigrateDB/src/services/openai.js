const OpenAI = require('openai');
const createFeatureLogger = require('./logger');
const logAuth = createFeatureLogger('Authetication');
const logThreads = createFeatureLogger('Threads');

/**
 * Authentication
 */
let authentication = async () => {
    try {
        const openai = new OpenAI({
            apiKey: process.env.OPENAI_SECRET_KEY,
            organization: process.env.OPENAI_ORGANIZATION_ID,
            project: process.env.OPENAI_PROJECT_ID,
        });
        return { success: true, data: openai };
    } catch (error) {
        logAuth.error(error.message);
        return { success: false };
    }
}

/**
 * Threads
 * @param {string} type - method of thread
 */
let threads = async (type, obj) => {
    try {
        var authOpenAI = await authentication().dât;
        var threadsData;
        switch (type) {
            case 'create':
                threadsData = await authOpenAI.beta.threads.create(obj);
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

        return { success: true, data: threadsData };
    } catch (error) {
        logThreads.error(error.message);
        return false;
    }

}

/**
 * Threads
 * @param {string} type - method of thread
 */
let assistants = async (type, obj) => {
    var authOpenAI = await authentication();
    switch (type) {
        case 'create':
            const create = authOpenAI.beta.assistants.create(obj);
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
    authentication,
    chatComplete: chatComplete,
    assistants: assistants,
    threads: threads
 }
