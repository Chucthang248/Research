const OpenAI = require('openai');
const createFeatureLogger = require('./logger');
const logOrg = createFeatureLogger('organizationAndProject');
const logAuth = createFeatureLogger('Authetication');

let orgAndProject = () => {
    try {
        const openai = new OpenAI({
            organization: process.env.OPENAI_ORGANIZATION_ID,
            project: process.env.OPENAI_PROJECT_ID,
        });
        return openai;
        // return {
        //      organization: process.env.OPENAI_ORGANIZATION_ID,
        //     project: process.env.OPENAI_PROJECT_ID,
        // }
    } catch (error) {
        logOrg.error(error.message);
        return false;
    }

}

module.exports = {
    orgAndProject
 }
