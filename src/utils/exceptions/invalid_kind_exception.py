class InvalidKindException(Exception):
    def __init__(self, invalid_kind):
        super().__init__(f'Invalid kind "{invalid_kind}", please try again with tempmin or tempmax')
