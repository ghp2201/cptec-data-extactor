from abc import ABC, abstractmethod

class ExporterInterface(ABC):
    @abstractmethod
    def export(self, *args, **kwargs):
        pass
