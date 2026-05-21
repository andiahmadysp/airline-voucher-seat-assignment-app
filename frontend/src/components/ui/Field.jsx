const Field = ({ label, name, type = 'text', size = 'md', hint = '', ...args }) => {
    return (
        <div className={`field ${size}`}>
            <label htmlFor={name}>{label} {hint && <span className={'hint'}>{hint}</span>}</label>
            {
                type === 'select' ?
                    <select id={name} name={name} {...args}>
                        <option value="">Select {name}…</option>

                        {args?.options?.map((option, index) => {
                            return (<option key={index} value={option}>{option}</option>)
                        })}
                    </select>
                    : <input id={name} name={name} type={type} {...args}/>
            }
        </div>
    );
};

export default Field;
