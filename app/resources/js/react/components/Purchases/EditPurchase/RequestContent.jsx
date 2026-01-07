import React from 'react';
import { useI18n } from '../../../../i18n/useI18n';

export default function RequestContent() {
    const { t } = useI18n();

    return (
        <div>
            <h2 className="h5">{t('Send to request')}</h2>
            <p>
                {t(
                    'Please check information again before sending request to manager for approval'
                )}
            </p>
            <p>
                {t(
                    'You will not be able to change data after requesting. If needed, you should create a new one'
                )}
            </p>
        </div>
    );
}
