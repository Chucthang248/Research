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

    let transportsType = [
        new transports.File({ filename: path.join(`logs/${featureName}/${logInfo}.log`), level: 'info' }),
        new transports.File({ filename: path.join(`logs/${featureName}/${logError}.log`), level: 'error' })
    ]

    // if user custom file log for test
    if (customFileName && level) {
        switch (level) {
            case 'info':
                transportsType = [new transports.File({ filename: path.join(`logs/${featureName}/${customFileName}.log`), level: 'info' })];
                break;
            case 'error':
                logError = customFileName;
                transportsType = [new transports.File({ filename: path.join(`logs/${featureName}/${customFileName}.log`), level: 'error' })];
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
        transports: transportsType,
        exceptionHandlers: [
            new transports.File({ filename: path.join(`logs/${featureName}/exceptions.log`) })
        ]
    });
};

module.exports = createFeatureLogger;