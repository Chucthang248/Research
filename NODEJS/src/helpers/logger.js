// loggerFactory.js
const { createLogger, format, transports } = require('winston');
const { combine, timestamp, printf } = format;
const path = require('path');
const logInfo = 'info';
const logError = 'error';

const createFeatureLogger = (featureName, customFileName, level) => {
    const logFormat = printf(({ level, message, timestamp }) => {
        return `${timestamp} [${level}]: ${message}`;
    });

    // if user custom file log for test
    if (customFileName && level) {
        switch (level) {
            case 'info':
                logInfo = customFileName;
                break;
            case 'error':
                logError = customFileName;
                break;
            default:
                break;
        }
    }

    return createLogger({
        level: 'info',
        format: combine(
            timestamp({ format: 'YYYY-MM-DD HH:mm:ss' }),
            logFormat
        ),
        transports: [
            new transports.File({ filename: path.join(`logs/${featureName}/${logInfo}.log`), level: 'info' }),
            new transports.File({ filename: path.join(`logs/${featureName}/${logError}.log`), level: 'error' })
        ],
        exceptionHandlers: [
            new transports.File({ filename: path.join(`logs/${featureName}/exceptions.log`) })
        ]
    });
};

module.exports = createFeatureLogger;