import React from 'react';

const Spinner = () => {
    return (
        <div className="flex justify-center absolute items-center">
            <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-white"></div>
        </div>
    );
};

export default Spinner;

